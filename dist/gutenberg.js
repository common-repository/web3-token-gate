!function(){"use strict";var e={n:function(t){var n=t&&t.__esModule?function(){return t.default}:function(){return t};return e.d(n,{a:n}),n},d:function(t,n){for(var a in n)e.o(n,a)&&!e.o(t,a)&&Object.defineProperty(t,a,{enumerable:!0,get:n[a]})},o:function(e,t){return Object.prototype.hasOwnProperty.call(e,t)}},t=window.wp.element,n=window.wp.i18n,a=window.wp.blocks,i=window.wp.blockEditor,o=window.wp.data,r=window.wp.primitives,s=(0,t.createElement)(r.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24"},(0,t.createElement)(r.Path,{d:"M16.7 7.1l-6.3 8.5-3.3-2.5-.9 1.2 4.5 3.4L17.9 8z"})),l=(0,t.createElement)(r.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24"},(0,t.createElement)(r.Path,{d:"M13 11.8l6.1-6.3-1-1-6.1 6.2-6.1-6.2-1 1 6.1 6.3-6.5 6.7 1 1 6.5-6.6 6.5 6.6 1-1z"}));[{name:"success-verification",isDefault:!0,title:(0,n.__)("Success Verfication Output"),description:(0,n.__)("Verification output that should be displayed when the token is valid."),icon:s,attributes:{type:"success"},isActive:(e,t)=>e.type===t.type,scope:[]},{name:"failure-verification",title:(0,n.__)("Failure Verfication Output"),description:(0,n.__)("Verification output that should be displayed when the token is invalid."),icon:l,attributes:{type:"failure"},isActive:(e,t)=>e.type===t.type,scope:[]}].forEach((e=>{(0,a.registerBlockVariation)("web3tokengate/verification-output",e)})),(0,a.registerBlockType)("web3tokengate/verification-output",{apiVersion:2,title:(0,n.__)("Verification Output","web3-token-gate"),description:(0,n.__)("Token gate verficiation output"),attributes:{type:{type:"string",enum:["success","failure"]}},supports:{inserter:!1,align:["full"]},edit:e=>{const a={success:(0,n.__)("Success Verification Output","web3-token-gate"),failure:(0,n.__)("Failure Verification Output","web3-token-gate")},o={success:(0,n.__)("Please create verification output that should be displayed when the token is valid.","web3-token-gate"),failure:(0,n.__)("Please create verification output that should be displayed when the token is invalid.","web3-token-gate")};return(0,t.createElement)("div",(0,i.useBlockProps)({className:"tokengate-verification-block type-"+e.attributes.type}),(0,t.createElement)("h3",null,a[e.attributes.type]),(0,t.createElement)("p",null,o[e.attributes.type]),(0,t.createElement)("div",{className:"tokengate-verification-content"},(0,t.createElement)(i.InnerBlocks,{templateLock:!1,renderAppender:i.InnerBlocks.ButtonBlockAppender})))},save:e=>(0,t.createElement)("div",i.useBlockProps.save({className:"tokengate-verification-block"}),(0,t.createElement)(i.InnerBlocks.Content,null))});var c=window.wp.domReady,u=e.n(c),d=window.wp.plugins,p=window.wp.components,w=window.wp.editPost;u()((()=>{(0,d.registerPlugin)("tokengate-token-address-picker",{render:()=>{const e="tokengate-token-address",a=(0,o.useSelect)((t=>{const n=t("core/editor").getEditedPostAttribute("meta");return e in n?n[e]:""})),{editPost:i}=(0,o.useDispatch)("core/editor");return(0,t.createElement)(w.PluginDocumentSettingPanel,{icon:()=>null,title:(0,n.__)("Token Address","wp-token-gate"),name:"wptokengate-token-address-panel",className:"wptokengate-token-address-panel"},(0,t.createElement)(p.TextControl,{label:(0,n.__)("Address","wp-token-gate"),onChange:t=>{i({meta:{[e]:t}})},value:a,placeholder:(0,n.__)("Enter token address...","wp-token-gate"),help:(0,n.__)("Enter the token address here.","wp-token-gate")}))}})}));var k=window.lodash;u()((()=>{(0,d.registerPlugin)("tokengate-chain-id-picker",{render:()=>{const e="tokengate-chain-id",a=(0,o.useSelect)((t=>{const n=t("core/editor").getEditedPostAttribute("meta");return e in n?n[e]:""})),{editPost:i}=(0,o.useDispatch)("core/editor"),r=["ethereum","polygon","arbitrum","optimism","ropsten","rinkeby","kovan","goerli","sepolia"].map((e=>({label:(0,k.capitalize)(e),value:e})));return(0,t.createElement)(w.PluginDocumentSettingPanel,{icon:()=>null,title:(0,n.__)("Chain Id","web3-token-gate"),name:"web3tokengate-chain-id-panel",className:"web3tokengate-chain-id-panel"},(0,t.createElement)(p.SelectControl,{label:(0,n.__)("Chain","web3-token-gate"),onChange:t=>{i({meta:{[e]:t}})},options:r,value:a,help:(0,n.__)("Select a block chain.","web3-token-gate")}))}})})),u()((()=>{(0,d.registerPlugin)("tokengate-token-button-classname",{render:()=>{const e="tokengate-button-classname",a=(0,o.useSelect)((t=>{const n=t("core/editor").getEditedPostAttribute("meta");return e in n?n[e]:""})),{editPost:i}=(0,o.useDispatch)("core/editor");return(0,t.createElement)(w.PluginDocumentSettingPanel,{icon:()=>null,title:(0,n.__)("Button Classname","wp-token-gate"),name:"wptokengate-token-address-panel",className:"wptokengate-token-address-panel"},(0,t.createElement)(p.TextControl,{onChange:t=>{i({meta:{[e]:t}})},value:a,placeholder:(0,n.__)("Add Class...","wp-token-gate"),help:(0,n.__)("This classname will be added on the main app verification button.","wp-token-gate")}))}})}))}();