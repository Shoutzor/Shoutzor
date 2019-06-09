require.config({
  shim: {
    'bootstrap': ['jquery'],
    'core': ['bootstrap', 'jquery'],
  },
  paths: {
    'core': 'assets/js/core',
    'jquery': 'assets/js/vendors/jquery-3.2.1.min',
    'bootstrap': 'assets/js/vendors/bootstrap.bundle.min'
  }
});

require(['core']);
