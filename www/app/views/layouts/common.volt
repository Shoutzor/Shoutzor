<div class="page-main">
  <div class="header py-4">
    <div class="container">
      <div class="d-flex">
        <a class="header-brand" href="/">
          <img src="/assets/images/shoutzor-logo-small.png" class="header-brand-img" alt="shoutzor logo">
        </a>
        <div class="d-flex order-lg-2 ml-auto">
          {% if auth == true %}
            <div class="nav-item d-none d-md-flex">
              <a href="/admin" class="btn btn-sm btn-outline-primary">Admin Settings</a>
            </div>

          <div class="dropdown">
            <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
              <span class="avatar" style="background-image: url(./demo/faces/female/25.jpg)"></span>
              <span class="ml-2 d-none d-lg-block">
                <span class="text-default">Xorinzor</span>
                <small class="text-muted d-block mt-1">Administrator</small>
              </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
              <a class="dropdown-item" href="#">
                <i class="dropdown-icon fe fe-user"></i> Profile
              </a>
              <a class="dropdown-item" href="#">
                <i class="dropdown-icon fe fe-settings"></i> Settings
              </a>
              <a class="dropdown-item" href="#">
                <i class="dropdown-icon fe fe-log-out"></i> Sign out
              </a>
            </div>
          </div>
          {% else %}
            <div class="nav-item d-none d-md-flex">
              {{ link_to('/register', 'Register', 'class': 'btn btn-sm btn-outline-primary mr-2')}}
              {{ link_to('/login', 'Login', 'class': 'btn btn-sm btn-outline-primary')}}
            </div>
          {% endif %}
        </div>
        <a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse" data-target="#headerMenuCollapse">
          <span class="header-toggler-icon"></span>
        </a>
      </div>
    </div>
  </div>

  <?php echo $this->getContent(); ?>

</div>

<footer class="footer">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-12 col-lg-auto mt-3 mt-lg-0 text-center">
        {% block footer %}<a href="https://shoutzor.jorinvermeulen.com">Shoutz0r</a>{% endblock %}
      </div>
    </div>
  </div>
</footer>
