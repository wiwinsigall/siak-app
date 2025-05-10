<!-- Core JS Files -->
<script src="{{ asset('assets/laravel-black/js/core/jquery.min.js') }}"></script>
<script src="{{ asset('assets/laravel-black/js/core/popper.min.js') }}"></script>
<script src="{{ asset('assets/laravel-black/js/core/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/laravel-black/js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>

<!-- Google Maps Plugin -->
<!-- Place this tag in your head or just before your closing body tag -->
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>

<!-- Chart JS -->
<script src="{{ asset('assets/laravel-black/js/plugins/chartjs.min.js') }}"></script>

<!-- Notifications Plugin -->
<script src="{{ asset('assets/laravel-black/js/plugins/bootstrap-notify.js') }}"></script>

<!-- Control Center for Black Dashboard: parallax effects, scripts for example pages, etc. -->
<script src="{{ asset('assets/laravel-black/js/black-dashboard.min.js?v=1.0.0') }}"></script>

<!-- Black Dashboard DEMO methods (do not include this in production) -->
<script src="{{ asset('assets/laravel-black/demo/demo.js') }}"></script>

<script>
  $(document).ready(function() {
    $().ready(function() {
      var $sidebar = $('.sidebar');
      var $navbar = $('.navbar');
      var $main_panel = $('.main-panel');
      var $full_page = $('.full-page');
      var $sidebar_responsive = $('body > .navbar-collapse');

      var sidebar_mini_active = true;
      var white_color = false;
      var window_width = $(window).width();
      var fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();

      // Handle sidebar plugin toggle
      $('.fixed-plugin a').click(function(event) {
        if ($(this).hasClass('switch-trigger')) {
          event.stopPropagation ? event.stopPropagation() : (window.event.cancelBubble = true);
        }
      });

      // Change background color
      $('.fixed-plugin .background-color span').click(function() {
        $(this).siblings().removeClass('active');
        $(this).addClass('active');

        var new_color = $(this).data('color');

        if ($sidebar.length !== 0) $sidebar.attr('data', new_color);
        if ($main_panel.length !== 0) $main_panel.attr('data', new_color);
        if ($full_page.length !== 0) $full_page.attr('filter-color', new_color);
        if ($sidebar_responsive.length !== 0) $sidebar_responsive.attr('data', new_color);
      });

      // Toggle sidebar mini mode
      $('.switch-sidebar-mini input').on("switchChange.bootstrapSwitch", function() {
        if (sidebar_mini_active) {
          $('body').removeClass('sidebar-mini');
          sidebar_mini_active = false;
          blackDashboard.showSidebarMessage('Sidebar mini deactivated...');
        } else {
          $('body').addClass('sidebar-mini');
          sidebar_mini_active = true;
          blackDashboard.showSidebarMessage('Sidebar mini activated...');
        }

        // Simulate window resize for chart updates
        var simulateWindowResize = setInterval(function() {
          window.dispatchEvent(new Event('resize'));
        }, 180);

        setTimeout(function() {
          clearInterval(simulateWindowResize);
        }, 1000);
      });

      // Toggle color mode
      $('.switch-change-color input').on("switchChange.bootstrapSwitch", function() {
        if (white_color) {
          $('body').addClass('change-background');
          setTimeout(function() {
            $('body').removeClass('change-background white-content');
          }, 900);
          white_color = false;
        } else {
          $('body').addClass('change-background');
          setTimeout(function() {
            $('body').removeClass('change-background').addClass('white-content');
          }, 900);
          white_color = true;
        }
      });

      // Light and Dark Mode
      $('.light-badge').click(function() {
        $('body').addClass('white-content');
      });

      $('.dark-badge').click(function() {
        $('body').removeClass('white-content');
      });
    });
  });
</script>

<script>
  $(document).ready(function() {
    // Initialize dashboard charts (method from assets/js/demos.js)
    demo.initDashboardPageCharts();
  });
</script>

<!-- TrackJS Monitoring -->
<script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
<script>
  if (window.TrackJS) {
    TrackJS.install({
      token: "ee6fab19c5a04ac1a32a645abde4613a",
      application: "black-dashboard-free"
    });
  }
</script>
