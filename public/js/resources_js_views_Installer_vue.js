"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_views_Installer_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/Installer.vue?vue&type=script&lang=js":
/*!**********************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/Installer.vue?vue&type=script&lang=js ***!
  \**********************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "Installer",
  data: function data() {
    return {
      showButton: true,
      showCustomButton: true,
      buttonIsLoading: false,
      buttonText: ''
    };
  },
  watch: {
    //This makes sure that if a custom button is hidden, this wont stay this way.
    //ie: every route will work with the same default values.
    $route: function $route(to, from) {
      this.resetButtonValues();
    }
  },
  computed: {
    progress: function progress() {
      var routes = this.$router.options.routes;
      var currentItem = routes.map(function (e) {
        return e.name;
      }).indexOf(this.$route.name);

      if (currentItem > 0) {
        return Math.round(100 / (routes.length - 1) * currentItem);
      } else {
        return 0;
      }
    },
    next: function next() {
      var routes = this.$router.options.routes;
      var currentItem = routes.map(function (e) {
        return e.name;
      }).indexOf(this.$route.name);

      if (routes.length > currentItem + 1) {
        return routes[currentItem + 1].name;
      } else {
        return null;
      }
    }
  },
  methods: {
    resetButtonValues: function resetButtonValues() {
      this.showButton = true;
      this.showCustomButton = true;
      this.buttonText = 'Next step';
      this.buttonIsLoading = false;
    },
    updateShowNextButton: function updateShowNextButton(show) {
      this.showButton = show;
    },
    updateShowCustomButton: function updateShowCustomButton(show) {
      this.showCustomButton = show;
    },
    updateButtonLoading: function updateButtonLoading(isLoading) {
      this.buttonIsLoading = isLoading;
    },
    updateButtonText: function updateButtonText(text) {
      this.buttonText = text;
    },
    // This method just emits an event so child-views can trigger their onClick listener
    buttonClickProxy: function buttonClickProxy() {
      this.emitter.emit('buttonClicked');
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/Installer.vue?vue&type=template&id=5648750e":
/*!**************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/Installer.vue?vue&type=template&id=5648750e ***!
  \**************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/@vue/compat/dist/vue.esm-bundler.js");
/* harmony import */ var _static_images_shoutzor_logo_large_png__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @static/images/shoutzor-logo-large.png */ "./resources/static/images/shoutzor-logo-large.png");


var _hoisted_1 = {
  id: "installer_wrapper"
};
var _hoisted_2 = {
  "class": "page"
};
var _hoisted_3 = {
  "class": "py-4"
};

var _hoisted_4 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "text-center mb-4"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("img", {
  alt: "Shoutz0r logo",
  "class": "logo filter-invert",
  src: _static_images_shoutzor_logo_large_png__WEBPACK_IMPORTED_MODULE_1__["default"]
})], -1
/* HOISTED */
);

var _hoisted_5 = {
  "class": "row align-items-center mt-3"
};
var _hoisted_6 = {
  "class": "col-4"
};
var _hoisted_7 = {
  "class": "progress"
};
var _hoisted_8 = ["aria-valuenow"];
var _hoisted_9 = {
  "class": "visually-hidden"
};
var _hoisted_10 = {
  "class": "col"
};
var _hoisted_11 = {
  "class": "d-flex justify-content-end"
};

var _hoisted_12 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Next Step ");

function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_router_view = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("router-view");

  var _component_router_link = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("router-link");

  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("main", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_3, [_hoisted_4, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_router_view, {
    showCustomButton: $options.updateShowCustomButton,
    showNextButton: $options.updateShowNextButton,
    updateButtonLoading: $options.updateButtonLoading,
    updateButtonText: $options.updateButtonText
  }, null, 8
  /* PROPS */
  , ["showCustomButton", "showNextButton", "updateButtonLoading", "updateButtonText"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_5, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_6, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_7, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    style: (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeStyle)({
      width: "".concat($options.progress, "%")
    }),
    "aria-valuemax": "100",
    "aria-valuemin": "0",
    "class": "progress-bar",
    role: "progressbar",
    "aria-valuenow": $options.progress
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_9, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.progress) + "% Complete", 1
  /* TEXT */
  )], 12
  /* STYLE, PROPS */
  , _hoisted_8)])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_10, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_11, [$data.showButton && $options.next !== null ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_router_link, {
    key: 0,
    to: {
      name: $options.next
    },
    "class": "btn btn-primary text-white"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_hoisted_12];
    }, undefined, true),
    _: 1
    /* STABLE */

  }, 8
  /* PROPS */
  , ["to"])) : $data.showButton === false && $data.showCustomButton === true ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("button", {
    key: 1,
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["btn btn-primary text-white", $data.buttonIsLoading ? 'btn-loading' : '']),
    onClick: _cache[0] || (_cache[0] = function () {
      return $options.buttonClickProxy && $options.buttonClickProxy.apply($options, arguments);
    })
  }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.buttonText), 3
  /* TEXT, CLASS */
  )) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])])])])])])]);
}

/***/ }),

/***/ "./resources/js/views/Installer.vue":
/*!******************************************!*\
  !*** ./resources/js/views/Installer.vue ***!
  \******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Installer_vue_vue_type_template_id_5648750e__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Installer.vue?vue&type=template&id=5648750e */ "./resources/js/views/Installer.vue?vue&type=template&id=5648750e");
/* harmony import */ var _Installer_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Installer.vue?vue&type=script&lang=js */ "./resources/js/views/Installer.vue?vue&type=script&lang=js");
/* harmony import */ var _home_xorinzor_Documents_git_Shoutz0r_app_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_home_xorinzor_Documents_git_Shoutz0r_app_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Installer_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Installer_vue_vue_type_template_id_5648750e__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/views/Installer.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/views/Installer.vue?vue&type=script&lang=js":
/*!******************************************************************!*\
  !*** ./resources/js/views/Installer.vue?vue&type=script&lang=js ***!
  \******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Installer_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Installer_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Installer.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/Installer.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/views/Installer.vue?vue&type=template&id=5648750e":
/*!************************************************************************!*\
  !*** ./resources/js/views/Installer.vue?vue&type=template&id=5648750e ***!
  \************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Installer_vue_vue_type_template_id_5648750e__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Installer_vue_vue_type_template_id_5648750e__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Installer.vue?vue&type=template&id=5648750e */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/Installer.vue?vue&type=template&id=5648750e");


/***/ })

}]);