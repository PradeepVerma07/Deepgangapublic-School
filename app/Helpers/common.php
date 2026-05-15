<?php
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;
use App\Models\Setting;
use App\Models\User;

if (!function_exists('getSetting')) {
    function getSetting($key)
    {
        static $settings = null;
        if ($settings === null) {
            try {
                $settings = Setting::pluck('value', 'title')->toArray();
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Failed to load settings: ' . $e->getMessage());
                $settings = [];
            }
        }
        return $settings[$key] ?? null;
    }
}
function getSubjectIcon($subject) {
    $icons = [
        'Mathematics' => '<i class="fas fa-calculator"></i>',
        'Physics' => '<i class="fas fa-atom"></i>',
        'Chemistry' => '<i class="fas fa-flask"></i>',
        'Biology' => '<i class="fas fa-dna"></i>',
        'English' => '<i class="fas fa-book-open"></i>',
        'Geography' => '<i class="fas fa-globe"></i>',
        'Computer Science' => '<i class="fas fa-laptop-code"></i>',
        'History' => '<i class="fas fa-landmark"></i>',
        'Physical Education' => '<i class="fas fa-running"></i>',
        'Elementary Education' => '<i class="fas fa-child"></i>',
    ];
    return $icons[$subject] ?? $icons['default'];
}
function getImageUrl($fileName)
{
    $uploadPath = Config::get('app.UPLOAD_PATH');
    $defaultImagePath =config('app.DEFAULT_IMAGE');
    if (!empty($fileName) && file_exists($uploadPath . $fileName)) {
        return config('app.IMGS_URL') . $fileName;
    }
    return  $defaultImagePath;
}
if (!function_exists('checkDuplicate')) {
    function checkDuplicate($table, $column, $value, $ignoreId = null)
    {
        $query = DB::table($table)->where($column, $value);

        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        return $query->exists();
    }
}

if (!function_exists('getData')) {
    function getData($table, $data = 0, $order = null, $orderBy = null, $limit = null, $start = null)
    {
        $query = DB::table($table);

        if ($order) {
            if ($orderBy) {
                $query->orderBy($orderBy, $order);
            } else {
                $query->orderBy('id', $order);
            }
        }

        if ($limit) {
            $query->limit($limit)->offset($start);
        }

        if ($data == 0 || $data == null) {
            return $query->get();
        }

        if (isset($data['search'])) {
            $search = $data['search'];
            unset($data['search']);
        }

        foreach ($data as $key => $value) {
            if (is_string($value) && strpos($key, ' !=') !== false) {
                $column = str_replace(' !=', '', $key);
                $query->where($column, '!=', $value);
            } else {
                $query->where($key, $value);
            }
        }

        return $query->get();
    }
}


if (!function_exists('getRow')) {
    function getRow($table, $data = 0)
    {
        if ($data == 0) {
            return DB::table($table)->first();
        } elseif (is_array($data)) {
            return DB::table($table)->where($data)->first();
        } else {
            return DB::table($table)->where('id', $data)->first();
        }
    }
}

if (!function_exists('prx')) {
    function prx($v)
    {
        echo '<pre>' . print_r($v, true) . '</pre>';
    }
}
if ( ! function_exists('encoding')) {
  function encoding($str){
      $one = serialize($str);
      $two = @gzcompress($one,9);
      $three = addslashes($two);
      $four = base64_encode($three);
      $five = strtr($four, '+/=', '-_.');
      return $five;
  }
}

if ( ! function_exists('decoding')) {
  function decoding($str){
    $one = strtr($str, '-_.', '+/=');
      $two = base64_decode($one);
      $three = stripslashes($two);
      $four = @gzuncompress($three);
      if ($four == '') {
          return "z1";
      } else {
          $five = unserialize($four);
          return $five;
      }
  }
}
if (!function_exists('log_activity')) {
    function log_activity(
        $action,
        $old_data = null,
        $new_data = null,
        $user_id = null,
        $ref_id = null,
        $module = 'general',
        $log_level = 'info',
        $status = 'success'
    ) {
        $ip_address = request()->ip();
        $url = request()->path() ?: '/';
        $http_method = request()->method();
        $user_agent = request()->header('User-Agent');

        $request_params = array_merge(request()->query->all(), request()->request->all());
        unset($request_params['password'], $request_params['password_confirm'], $request_params['otp']);
        $request_params = !empty($request_params) ? json_encode($request_params) : null;

        $role = 'guest';
        if ($user_id) {
            $user = DB::table('users')->select('userRole')->where('userID', $user_id)->first();
            $role = $user->userRole ?? 'guest';
        }

        $old_data_json = is_array($old_data) || is_object($old_data) ? json_encode($old_data) : $old_data;
        $new_data_json = is_array($new_data) || is_object($new_data) ? json_encode($new_data) : $new_data;

        $log_data = [
            'user_id' => $user_id,
            'ref_id' => $ref_id,
            'role' => $role,
            'action' => $action,
            'old_data' => $old_data_json,
            'new_data' => $new_data_json,
            'ip_address' => $ip_address,
            'url' => $url,
            'http_method' => $http_method,
            'user_agent' => $user_agent,
            'request_params' => $request_params,
            'status' => $status,
            'module' => $module,
            'log_level' => $log_level,
            'created_at' => now()
        ];

        try {
            DB::table('system_logs')->insert($log_data);
        } catch (\Exception $e) {
            Log::error("Failed to log activity: Action=$action, UserID=$user_id, Error=" . $e->getMessage());
        }
    }
}

function generateMenu($roleId) {
    $permissions = DB::table('admin_menus')
        ->leftJoin('admin_role_menus', 'admin_menus.id', '=', 'admin_role_menus.menu_id')
        ->where('admin_role_menus.role_id', $roleId)
        ->where('admin_role_menus.view', 1)
        ->where('admin_menus.active', 1)
        ->select('admin_menus.*')
        ->orderBy('admin_menus.seq', 'ASC')
        ->get();

    $menuMap = [];
    foreach ($permissions as $permission) {
        $menuMap[$permission->id] = $permission;
    }

    $menuTree = array_filter($menuMap, function ($permission) {
        return $permission->parent == 0;
    });

    usort($menuTree, function($a, $b) {
        return ($a->seq ?? 0) - ($b->seq ?? 0);
    });
    $currentUrl = explode('/', Request::path())[1] ?? '';
    $isDashboardActive = $currentUrl == 'dashboard' ? 'active' : '';

    $html = '<div id="sidebar-menu" class="sidebar-menu">';
    $html .= '<ul>';
    $html .= '<a href="' . route('admin.dashboard') . '" class="' . $isDashboardActive . '">';
    $html .= '<i class="ti ti-smart-home"></i>';
    $html .= '<span>Dashboard</span>';
    $html .= '</a>';
    $html .= '</li>';

    $menuGroups = [];
    foreach ($menuTree as $menu) {
        $groupTitle = $menu->title;
        if (!isset($menuGroups[$groupTitle])) {
            $menuGroups[$groupTitle] = [];
        }
        $menuGroups[$groupTitle][] = $menu;
    }

    foreach ($menuGroups as $groupTitle => $menus) {
        $html .= '<li><ul>';

        foreach ($menus as $menu) {
            $html .= renderMenuRecursive($menu, $currentUrl, $menuMap);
        }

        $html .= '</ul></li>';
    }

    $html .= '</ul>';
    $html .= '</div>';

    return $html;
}

function renderMenuRecursive($menu, $currentUrl, $menuMap, $level = 1) {
    $subMenus = array_filter($menuMap, function ($permission) use ($menu) {
        return $permission->parent == $menu->id;
    });

    usort($subMenus, function($a, $b) {
        return ($a->seq ?? 0) - ($b->seq ?? 0);
    });

    $isActive = $currentUrl == $menu->url;
    foreach ($subMenus as $subMenu) {
        if ($currentUrl == $subMenu->url) {
            $isActive = true;
            break;
        }
        $subSubMenus = array_filter($menuMap, function ($permission) use ($subMenu) {
            return $permission->parent == $subMenu->id;
        });
        foreach ($subSubMenus as $subSubMenu) {
            if ($currentUrl == $subSubMenu->url) {
                $isActive = true;
                break 2;
            }
        }
    }

    $hasSubMenus = !empty($subMenus);
    $collapseId = 'menu-' . $menu->id;
    $submenuClass = $level == 1 && $hasSubMenus ? ' submenu' : '';

    $html = '<li class="' . $submenuClass . '">';

    if ($hasSubMenus && $level <= 2) {
        $html .= '<a href="javascript:void(0);" class="' . ($isActive ? 'active subdrop' : '') . '">';
        $html .= '<i class="' . htmlspecialchars($menu->icon) . '"></i>';
        $html .= '<span>' . htmlspecialchars($menu->title) . '</span>';
        $html .= '<span class="menu-arrow' . ($level > 1 ? ' inside-submenu' : '') . '"></span>';
        $html .= '</a>';
        $html .= '<ul' . ($isActive ? ' style="display: block;"' : '') . '>';

        foreach ($subMenus as $subMenu) {
            $html .= renderMenuRecursive($subMenu, $currentUrl, $menuMap, $level + 1);
        }

        $html .= '</ul>';
    } else {
        $html .= '<a href="' . url('admin/' . $menu->url) . '" class="' . ($isActive ? 'active' : '') . '">';
        $html .= '<i class="' . htmlspecialchars($menu->icon) . '"></i>';
        $html .= '<span>' . htmlspecialchars($menu->title) . '</span>';
        $html .= '</a>';
    }

    $html .= '</li>';
    return $html;
}


if (!function_exists('generate_breadcrumb')) {
    function generate_breadcrumb($url = null)
    {
        $url = $url ?? explode('/', Request::path())[1];
        $pathParts = explode('/', Request::path());

        $entity = null;
        if (isset($pathParts[2]) && is_numeric($pathParts[2])) {
            $entity = $pathParts[3] ?? null;
        } elseif (isset($pathParts[2])) {
            $entity = $pathParts[2];
        }

        $menu = DB::table('admin_menus')
            ->where('url', $url)
            ->where('active', 1)
            ->first();

        $title = $menu ? htmlspecialchars($menu->title) : 'Admin Dashboard';

        $html = '<div class="my-auto mb-2">';
        $html .= '<h2 class="mb-1">' . $title . '</h2>';
        $html .= '<nav>';
        $html .= '<ol class="breadcrumb mb-0">';

        $html .= '<li class="breadcrumb-item">';
        $html .= '<a href="' . url('admin/dashboard') . '"><i class="ti ti-smart-home"></i></a>';
        $html .= '</li>';

        if ($url == 'dashboard' || !$menu) {
            $html .= '<li class="breadcrumb-item">';
            $html .= 'Dashboard';
            $html .= '</li>';
            $html .= '<li class="breadcrumb-item active" aria-current="page">Admin Dashboard</li>';
        } else {
            $hierarchy = [];
            $currentMenu = $menu;

            while ($currentMenu && $currentMenu->parent != 0) {
                $parentMenu = DB::table('admin_menus')
                    ->where('id', $currentMenu->parent)
                    ->where('active', 1)
                    ->first();
                if ($parentMenu) {
                    array_unshift($hierarchy, $parentMenu);
                    $currentMenu = $parentMenu;
                } else {
                    break;
                }
            }

            foreach ($hierarchy as $parent) {
                $html .= '<li class="breadcrumb-item">';
                $html .= '<a href="' . url('admin/' . $parent->url) . '">' . htmlspecialchars($parent->title) . '</a>';
                $html .= '</li>';
            }

            $html .= '<li class="breadcrumb-item active" aria-current="page">';
            $html .= htmlspecialchars($menu->title);
            $html .= '</li>';

            if (!empty($entity)) {
                $html .= '<li class="breadcrumb-item active" aria-current="page">';
                $html .= ucfirst(htmlspecialchars($entity));
                $html .= '</li>';
            }
        }

        $html .= '</ol>';
        $html .= '</nav>';
        $html .= '</div>';

        return $html;
    }
}


if (!function_exists('checkPermission')) {
    function checkPermission(string $action = 'view'): bool
    {
        $segments = explode('/', Request::path());
        $url = $segments[1] ?? null;

        if (!$url) {
            return false;
        }

        if (Auth::guard('admin')->check()) {
            $user = Auth::guard('admin')->user();
        } elseif (Auth::guard('employer')->check()) {
            $user = Auth::guard('employer')->user();
        } else {
            return false;
        }

        if (!$user || !$user->userRole) {
            return false;
        }
        $role = DB::table('roles_new')
            ->where('roleKey', $user->userRole)
            ->where('status', 1)
            ->first();

        if (!$role || !$role->id) {
            return false;
        }
        $permission = DB::table('permissions_new')
            ->where('url', $url)
            ->where('status', 1)
            ->first();

        if (!$permission) {
            return false;
        }
        $rolePermission = DB::table('role_permissions')
            ->where('role_id', $role->id)
            ->where('permission_id', $permission->id)
            ->first();

        if (!$rolePermission) {
            return false;
        }

        switch ($action) {
            case 'add':
                return $rolePermission->add == 1;
            case 'edit':
                return $rolePermission->edit == 1;
            case 'delete':
                return $rolePermission->delete == 1;
            case 'show':
            case 'show_menu':
                return $rolePermission->show_menu == 1;
            case 'view':
            default:
                return $rolePermission->view == 1;
        }
    }
}


function renderPagination($paginator)
{
    if ($paginator->lastPage() <= 1) {
        return '';
    }

    $html = '<div class="d-flex justify-content-between align-items-center mt-4">';
    $html .= '<div class="text-muted">';
    $html .= 'Showing ' . $paginator->firstItem() . ' to ' . $paginator->lastItem() . ' of ' . $paginator->total() . ' entries';
    $html .= '</div>';
    $html .= '<nav aria-label="Users pagination">';
    $html .= '<ul class="pagination mb-0">';

    if ($paginator->onFirstPage()) {
        $html .= '<li class="page-item disabled">';
        $html .= '<a class="page-link" href="#" tabindex="-1" aria-disabled="true"><i class="fas fa-chevron-left"></i></a>';
        $html .= '</li>';
    } else {
        $html .= '<li class="page-item">';
        $html .= '<a class="page-link" href="' . $paginator->previousPageUrl() . '" rel="prev"><i class="fas fa-chevron-left"></i></a>';
        $html .= '</li>';
    }

    // Page Numbers
    foreach ($paginator->links()->elements as $element) {
        if (is_string($element)) {
            $html .= '<li class="page-item disabled"><a class="page-link" href="#">' . $element . '</a></li>';
        }

        if (is_array($element)) {
            foreach ($element as $page => $url) {
                if ($page == $paginator->currentPage()) {
                    $html .= '<li class="page-item active">';
                    $html .= '<a class="page-link" href="#" style="background-color: var(--primary-color); border-color: var(--primary-color);">' . $page . '</a>';
                    $html .= '</li>';
                } else {
                    $html .= '<li class="page-item"><a class="page-link" href="' . $url . '">' . $page . '</a></li>';
                }
            }
        }
    }

    if ($paginator->hasMorePages()) {
        $html .= '<li class="page-item">';
        $html .= '<a class="page-link" href="' . $paginator->nextPageUrl() . '" rel="next"><i class="fas fa-chevron-right"></i></a>';
        $html .= '</li>';
    } else {
        $html .= '<li class="page-item disabled">';
        $html .= '<a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>';
        $html .= '</li>';
    }

    $html .= '</ul>';
    $html .= '</nav>';
    $html .= '</div>';

    return $html;
}


/**
     * Geocode an address or return the cleaned address
     * @param string $address The input address to process
     * @param string $apiKey Google Maps API key
     * @return array|string Returns array with lat/lng or error message
     */

    if (!function_exists('geocodeAddress')) {
        function geocodeAddress($address)
        {
            $apiKey = Config::get('app.GOOGLE_MAP');
            $cleanAddress = preg_replace('/\b(S\/O|C\/O|D\/O|W\/O)[^,]*,?/i', '', $address);
            $cleanAddress = trim($cleanAddress);

            $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
                'address' => $cleanAddress,
                'key' => $apiKey,
            ]);

            $data = $response->json();

            if ($response->successful() && isset($data['status']) && $data['status'] === 'OK') {
                $latitude = $data['results'][0]['geometry']['location']['lat'];
                $longitude = $data['results'][0]['geometry']['location']['lng'];
                return [
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'address' => $cleanAddress
                ];
            }
            return [
                'latitude' => null,
                'longitude' => null,
                'address' => $cleanAddress,
                'error' => 'Error: ' . ($data['status'] ?? 'Request failed')
            ];
        }
    }

    /**
     * Geocode an address and extract state, city, and pincode
     * @param string $address The input address to process
     * @param string $apiKey Google Maps API key
     * @return array|string Returns array with state, city, pincode, and cleaned address or error message
     */
    if (!function_exists('getStateCityPincodeFromAddress')) {
        function getStateCityPincodeFromAddress($address)
        {
            $apiKey = Config::get('app.GOOGLE_MAP');
            $cleanAddress = preg_replace('/\b(S\/O|C\/O|D\/O|W\/O)[^,]*,?/i', '', $address);
            $cleanAddress = trim($cleanAddress);

            $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
                'address' => $cleanAddress,
                'key' => $apiKey,
            ]);

            $data = $response->json();

            if ($response->successful() && isset($data['status']) && $data['status'] === 'OK') {
                $addressComponents = $data['results'][0]['address_components'];

                $state = '';
                $city = '';
                $pincode = '';

                foreach ($addressComponents as $component) {
                    if (in_array('administrative_area_level_1', $component['types'])) {
                        $state = $component['long_name'];
                    }
                    if (in_array('locality', $component['types']) || in_array('sublocality', $component['types'])) {
                        $city = $component['long_name'];
                    }
                    if (in_array('postal_code', $component['types'])) {
                        $pincode = $component['long_name'];
                    }
                }

                return [
                    'state' => $state,
                    'city' => $city,
                    'pincode' => $pincode,
                    'address' => $cleanAddress
                ];
            }
            return [
                'state' => '',
                'city' => '',
                'pincode' => '',
                'address' => $cleanAddress,
                'error' => 'Error: ' . ($data['status'] ?? 'Request failed')
            ];
        }

    }


        /**
     * Convert UTC date to Indian Standard Time (IST) and format it.
     *
     * @param string $utcDate UTC date string (e.g., '2025-07-31')
     * @param string $format Desired output format (e.g., 'd M Y')
     * @return string Formatted IST date or empty string on error
     */
if (!function_exists('convertUtcToIstDate')) {
    function convertUtcToIstDate(string $utcDate, string $format = 'd M Y'): string
    {
        try {
            $dateTime = new DateTime($utcDate, new DateTimeZone('UTC'));
            $dateTime->setTimezone(new DateTimeZone('Asia/Kolkata'));
            return $dateTime->format($format);
        } catch (Exception $e) {
            return '';
        }
    }
}
    /**
     * Convert UTC datetime to Indian Standard Time (IST) and format it.
     *
     * @param string $utcDateTime UTC datetime string (e.g., '2025-07-31 17:14:01')
     * @param string $format Desired output format (e.g., 'd M Y H:i:s')
     * @return string Formatted IST datetime or empty string on error
     */
if (!function_exists('convertUtcToIstDateTime')) {
    function convertUtcToIstDateTime(string $utcDateTime, string $format = 'd M Y H:i:s'): string
    {
        try {
            $dateTime = new DateTime($utcDateTime, new DateTimeZone('UTC'));
            $dateTime->setTimezone(new DateTimeZone('Asia/Kolkata'));
            return $dateTime->format($format);
        } catch (Exception $e) {
            return '';
        }
    }
}

if (!function_exists('dashboardDate')) {
    function dashboardDate()
    {
        return \Carbon\Carbon::now()->setTimezone('Asia/Kolkata')->format('l, F d, Y');
    }
}

if (!function_exists('sendWhatsAppReminder')) {
    function sendWhatsAppReminder($to, $templateName, $parameters, $imageLink = null)
    {
        $url = 'https://jobipo.timespanel.in/wa/v2/messages/send';
        $headers = [
            'Authorization: c3f58bb70ed23cf6d7b24321b0cb046797c91be9b5830ef7f9',
            'Content-Type: application/json'
        ];

        $templateComponents = [];
        if (!empty($parameters)) {
            $templateComponents[] = [
                'type' => 'body',
                'parameters' => $parameters
            ];
        }
        if ($imageLink) {
            $templateComponents[] = [
                'type' => 'header',
                'parameters' => [
                    [
                        'type' => 'image',
                        'image' => [
                            'link' => $imageLink
                        ]
                    ]
                ]
            ];
        }

        $payload = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $to,
            'type' => 'template',
            'template' => [
                'name' => $templateName,
                'language' => [
                    'code' => 'en'
                ],
                'components' => $templateComponents
            ]
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode == 200) {
            return ['status' => 'success', 'response' => json_decode($response, true)];
        } else {
            return ['status' => 'failed', 'http_code' => $httpCode, 'response' => json_decode($response, true)];
        }
    }
}


/**
     * Get the active plan details for the authenticated user.
     *
     * @return object|null
     */
if (!function_exists('getActivePlanDetails')) {
    function getActivePlanDetails()
    {
        $userId = Auth::guard('employer')->user()->userID;
        if (!$userId) {
            return null;
        }
        return User::select('active_plan_id', 'available_credits', 'free_credit_is_used', 'job_post_limit')
                   ->where('userID', $userId)
                   ->first();
    }
}
