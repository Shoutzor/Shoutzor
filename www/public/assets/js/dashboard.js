require.config({
  shim: {
    'bootstrap': ['jquery'],
    'intro': ['jquery', 'bootstrap']
  },
  paths: {
    'jquery': [
      'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min',
      'assets/js/vendors/jquery-3.2.1.min'
    ],
    'bootstrap': [
      'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/js/bootstrap.bundle.min',
      'assets/js/vendors/bootstrap.bundle.min'
    ],
    'intro': [
      'https://cdnjs.cloudflare.com/ajax/libs/intro.js/2.9.3/intro.min',
      'assets/js/vendors/intro.min'
    ]
  }
});

require(['bootstrap']);
