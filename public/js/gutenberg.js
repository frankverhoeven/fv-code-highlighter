!function(e,t){if("object"==typeof exports&&"object"==typeof module)module.exports=t(require("lodash"));else if("function"==typeof define&&define.amd)define(["lodash"],t);else{var n=t("object"==typeof exports?require("lodash"):e.lodash);for(var r in n)("object"==typeof exports?exports:e)[r]=n[r]}}("undefined"!=typeof self?self:this,function(e){return function(e){function t(r){if(n[r])return n[r].exports;var o=n[r]={i:r,l:!1,exports:{}};return e[r].call(o.exports,o,o.exports,t),o.l=!0,o.exports}var n={};return t.m=e,t.c=n,t.d=function(e,n,r){t.o(e,n)||Object.defineProperty(e,n,{configurable:!1,enumerable:!0,get:r})},t.n=function(e){var n=e&&e.__esModule?function(){return e.default}:function(){return e};return t.d(n,"a",n),n},t.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},t.p="",t(t.s=0)}([function(e,t,n){e.exports=n(1)},function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var r=n(2),o=(n.n(r),wp.i18n.__),l=wp.hooks.addFilter,a=wp.compose.createHigherOrderComponent,c=wp.element.Fragment,u=wp.editor,i=u.InspectorControls,s=(u.BlockControls,wp.components),f=s.PanelBody,p=s.SelectControl,d=[{value:"",label:o("Other","fvch")},{value:"bash",label:o("Bash","fvch")},{value:"css",label:o("CSS","fvch")},{value:"javascript",label:o("Javascript","fvch")},{value:"html",label:o("HTML","fvch")},{value:"php",label:o("PHP","fvch")},{value:"xml",label:o("XML","fvch")}];l("blocks.registerBlockType","fv-code-highlighter/attribute/language",function(e,t){return"core/code"!==t?e:(e.attributes=Object(r.assign)(e.attributes,{language:{type:"string",default:""}}),e)}),l("editor.BlockEdit","efv-code-highlighter/code-language-select",a(function(e){return function(t){if("core/code"!==t.name)return wp.element.createElement(e,t);var n=t.setAttributes,r=t.attributes.language;return wp.element.createElement(c,null,wp.element.createElement(e,t),wp.element.createElement(i,null,wp.element.createElement(f,{title:"FV Code Highlighter",initialOpen:!0},wp.element.createElement(p,{label:"Language",value:r,options:d,onChange:function(e){return n({language:e})}}))))}},"codeLanguageSelect"))},function(t,n){t.exports=e}])});
//# sourceMappingURL=gutenberg.js.map