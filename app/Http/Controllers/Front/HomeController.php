<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Banner;
use App\Models\LatestNews;
use App\Models\WebsiteMenu;
use App\Models\Gallery;
use App\Models\Topper;
use App\Models\Testimonial;
use App\Models\Faq;
use App\Models\Message;
use App\Models\Teacher;
use App\Models\Contact;
use App\Models\GalleryCategory;
use App\Models\BrandPartner;
use App\Models\Service;
use App\Models\MembershipOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function template($page, $data)
    {
        $data['comp'] = getSetting('app_name');
        if (!isset($data['title'])) {
            $data['title'] = $data['comp'];
        }
        $data['school'] = $this->userData();

        $data['menus'] = WebsiteMenu::where('school_id', $data['school']->id)
            ->where('active', 1)
            ->orderBy('seq')
            ->get()
            ->groupBy('parent_id')
            ->toArray();
        $data['menuFooters'] = WebsiteMenu::where('school_id', $data['school']->id)
            ->where('active', 1)
            ->where('parent_id', '=', NULL)
            ->orderBy('seq')
            ->get();

        return view($page, $data);
    }

    public function userData()
    {
        return User::where(['active' => '1', 'id' => '2'])->first();
    }

    public function index()
    {
        $page = 'front.index';
        $title = 'Home Page';
        $user = $this->userData();
        $banners = Banner::where(['active' => '1', 'school_id' => $user->school_id])->orderBy('seq', 'ASC')->get();
        $news = LatestNews::where(['active' => '1', 'school_id' => $user->school_id])->orderBy('seq', 'ASC')->get();
        $teachers = Teacher::where(['active' => 1, 'school_id' => $user->school_id])
            ->orderBy('seq', 'ASC')
            ->get();
        $messages = Message::where([
            'active' => 1,
            'school_id' => $user->school_id
        ])->orderBy('seq', 'ASC')->get();
        $toppers = Topper::with('class')   // <-- LOAD RELATIONSHIP
            ->where([
                'active' => 1,
                'school_id' => $user->school_id
            ])
            ->orderBy('class_id', 'ASC')
            ->orderBy('marks', 'DESC')
            ->get();




        $galleryCategories = GalleryCategory::where(['active' => 1, 'school_id' => $user->school_id])
            ->with([
                'gallery' => function ($query) {
                    $query->where('active', 1)->orderBy('seq', 'ASC');
                }
            ])
            ->orderBy('seq', 'ASC')
            ->get();
        // Get all galleries and limit to latest 9
        $galleries = $galleryCategories->pluck('gallery')->flatten()
            ->sortByDesc('created_at') // ensure the latest come first
            ->take(9);
        $services = Service::where(['active' => '1', 'school_id' => $user->school_id])->orderBy('seq', 'ASC')->get();
        $testimonials = Testimonial::where(['active' => '1', 'school_id' => $user->school_id])->orderBy('seq', 'ASC')->get();
        $faqs = Faq::where(['active' => 1, 'school_id' => $user->school_id])
            ->orderBy('seq', 'ASC')
            ->get();
        $brandPartners = BrandPartner::where([
            'active' => 1,
            'school_id' => $user->school_id
        ])->orderBy('seq', 'ASC')->get();

        return $this->template($page, compact('title', 'banners', 'news', 'galleries', 'services', 'testimonials', 'faqs', 'galleryCategories', 'brandPartners', 'teachers', 'messages', 'toppers'));
    }

    public function contact()
    {
        $page = 'front.contact';
        $title = 'Contact Us';
        return $this->template($page, compact('title'));
    }

    public function about()
    {
        $page = 'front.about';
        $title = 'About Us';
        $user = $this->userData();

        // Get active teachers for the current school
        $teachers = Teacher::where(['active' => 1, 'school_id' => $user->school_id])
            ->orderBy('seq', 'ASC')
            ->get();

        return $this->template($page, compact('title', 'teachers'));
    }
    public function gallery(Request $request)
    {
        $page = 'front.gallery';
        $title = 'Gallery';
        $user = $this->userData();
        $category_id = $request->get('category');

        $categories = GalleryCategory::where(['school_id' => $user->school_id, 'active' => 1])
            ->orderBy('seq')
            ->get();

        $query = Gallery::where(['school_id' => $user->school_id, 'active' => 1])
            ->with('category');

        if ($category_id) {
            $query->where('category_id', $category_id);
        }

        $images = $query->orderBy('seq')->paginate(20);

        return $this->template($page, compact('title', 'categories', 'images', 'category_id'));
    }

    public function termsConditions()
    {
        $page = 'front.terms_conditions';
        $title = 'Terms & Conditions';
        return $this->template($page, compact('title'));
    }

    public function privacyPolicy()
    {
        $page = 'front.privacy_policy';
        $title = 'Privacy Policy';
        return $this->template($page, compact('title'));
    }

    public function disclosure()
    {
        $page = 'front.disclosure';
        $title = 'Disclosure';
        return $this->template($page, compact('title'));
    }


    public function brandPartner()
    {
        $page = 'front.brand_partner';
        $title = 'Brand Partner';

        // Get logged-in school user
        $user = $this->userData();

        // Fetch testimonials
        $testimonials = Testimonial::where([
            'active' => '1',
            'school_id' => $user->school_id
        ])
            ->orderBy('seq', 'ASC')
            ->get();

        return $this->template($page, compact('title', 'testimonials'));
    }
    public function training()
    {
        $page = 'front.training';
        $title = 'Training';
        return $this->template($page, compact('title'));
    }
    public function membershipOffer()
    {
        $page = 'front.membership_offer';
        $title = 'Membership Offer';
        $user = $this->userData();
        $images = MembershipOffer::where(['school_id' => $user->school_id, 'active' => 1])->orderBy('seq')->get();
        return $this->template($page, compact('title', 'images'));
    }
    public function academy()
    {
        $page = 'front.academy';
        $title = 'Academy';
        return $this->template($page, compact('title'));
    }
    public function ourServices()
    {
        $user = $this->userData();
        $page = 'front.our_services';
        $title = 'Our Services';
        $news = LatestNews::where(['active' => '1', 'school_id' => $user->school_id])->orderBy('seq', 'ASC')->get();
        $services = Service::where(['active' => '1', 'school_id' => $user->school_id])
            ->orderBy('seq', 'ASC')
            ->paginate(6);
        return $this->template($page, compact('title', 'services', ''));
    }
    public function servicesDetail(Request $request)
    {
        $page = 'front.service_details';
        $title = 'Service Details';
        $slug = $request->slug;
        $user = $this->userData();
        $service = Service::where(['slug' => $slug, 'active' => '1', 'school_id' => $user->school_id])->first();
        return $this->template($page, compact('title', 'service'));
    }


    public function notices()
    {
        $user = $this->userData();
        $page = 'front.notices';
        $title = 'School Notices';

        // notices = latest news
        $notices = LatestNews::where([
            'active' => 1,
            'school_id' => $user->school_id
        ])
            ->orderBy('seq', 'ASC')
            ->paginate(10);   // pagination enabled

        return $this->template($page, compact('title', 'notices'));
    }


    public function contactSubmit(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json(['status' => 'error', 'message' => 'Invalid request'], 400);
        }
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|max:10',
            'subject' => 'required',
            'message' => 'required',
            'school_id' => 'required',
        ], [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Email is invalid',
            'phone.required' => 'Phone is required',
            'phone.max' => 'Phone must be 10 digits',
            'school_id.required' => 'School ID is required',
        ]);
        $contact = Contact::create($request->all());
        $contact->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Contact submitted successfully'
        ]);
    }


    public function allToppers()
    {
        $user = $this->userData();
        $page = 'front.toppers';
        $title = "Toppers";

        $toppers = Topper::where([
            'active' => 1,
            'school_id' => $user->school_id
        ])
            ->orderBy('marks', 'DESC')
            ->get();

        $year = "2024 - 2025";

        return $this->template($page, compact('title', 'toppers', 'year'));
    }



    // public function indexs()
    // {
    //     return view('index');
    // }
    // public function about()
    // {
    //     return view('about');
    // }

    // public function contact()
    // {
    //     return view('contact');
    // }
    // public function media()
    // {
    //     return view('gallery');
    // }

    // public function academics()
    // {
    //     return view('academics');
    // }

    // public function application()
    // {
    //     return view('application-form');
    // }

    // public function addmission()
    // {
    //     return view('addmission');

    // }

    // public function howtoapply()
    // {
    //     return view('how-to-apply');
    // }

    // public function tuitionfee()
    // {
    //     return view('tuition-fee');
    // }

    // public function excellence()
    // {
    //     return view('alumni');
    // }

    // public function facilities()
    // {
    //     return view('facility');
    // }

}
