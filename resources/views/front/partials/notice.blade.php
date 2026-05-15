@if(isset($globalNotice) && $globalNotice['show'])
    <div class="global-notice alert alert-{{ $globalNotice['type'] }} alert-dismissible fade show mb-0" role="alert" id="global-notice" style="border-radius: 0; z-index: 9999;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-11">
                    <strong>
                        @if($globalNotice['type'] == 'info')
                            <i class="fas fa-info-circle"></i> Notice:
                        @elseif($globalNotice['type'] == 'success')
                            <i class="fas fa-check-circle"></i> Update:
                        @elseif($globalNotice['type'] == 'warning')
                            <i class="fas fa-exclamation-triangle"></i> Important:
                        @elseif($globalNotice['type'] == 'danger')
                            <i class="fas fa-exclamation-circle"></i> Alert:
                        @endif
                    </strong>
                    <span>{{ $globalNotice['message'] }}</span>
                </div>
                @if($globalNotice['dismissible'])
                    <div class="col-md-1 text-end">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" onclick="dismissNotice()"></button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Check if notice was dismissed (stored in localStorage)
        if (localStorage.getItem('noticeDismissed') === 'true') {
            document.getElementById('global-notice').style.display = 'none';
        }

        function dismissNotice() {
            localStorage.setItem('noticeDismissed', 'true');
            document.getElementById('global-notice').style.display = 'none';
        }

        // Optional: Auto-dismiss after certain time (uncomment if needed)
        // setTimeout(function() {
        //     if (document.getElementById('global-notice')) {
        //         document.getElementById('global-notice').style.display = 'none';
        //     }
        // }, 10000); // 10 seconds
    </script>

    <style>
        .global-notice {
            position: sticky;
            top: 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .global-notice .container {
            padding: 12px 15px;
        }

        .global-notice strong {
            margin-right: 8px;
        }

        .global-notice .btn-close {
            padding: 0.5rem;
            opacity: 0.8;
        }

        .global-notice .btn-close:hover {
            opacity: 1;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .global-notice .container {
                padding: 10px;
            }
            .global-notice strong {
                display: block;
                margin-bottom: 5px;
            }
        }
    </style>
@endif

