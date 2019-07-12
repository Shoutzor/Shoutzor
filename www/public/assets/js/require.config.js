require.config({
  baseUrl: '/',
  shim: {
    'bootstrap': ['jquery'],
    'uikit': ['jquery'],
    'intro': ['jquery', 'bootstrap'],
    'upload/index': ['jquery', 'uikit'],
    'jsrender': ['jquery']
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
    'uikit': [
      'https://cdnjs.cloudflare.com/ajax/libs/uikit/2.26.4/js/uikit.min',
      'assets/js/vendors/uikit.min'
    ],
    'intro': [
      'https://cdnjs.cloudflare.com/ajax/libs/intro.js/2.9.3/intro.min',
      'assets/js/vendors/intro.min'
    ],
    'upload': [
      'https://cdnjs.cloudflare.com/ajax/libs/uikit/2.26.4/js/components/upload.min',
      'assets/js/vendors/upload.min'
    ],
    'jsrender': [
      'https://cdnjs.cloudflare.com/ajax/libs/jsrender/1.0.3/jsrender.min',
      'assets/js/vendors/jsrender.min'
    ],

    //App libraries
    'uploadmanager': [
      'assets/js/app/uploadmanager'
    ],

    //view-specific javascript
    'upload/index': [
      'assets/js/app/upload/index'
    ]
  }
});
