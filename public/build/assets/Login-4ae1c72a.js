import{h as w,i as k,j as x,u as s,o as d,f as h,k as v,v as y,c as u,w as m,a,X as V,t as $,g as c,b as r,l as B,d as f,n as C,e as N}from"./app-4055e645.js";import{_ as R}from"./GuestLayout-cefc48cf.js";import{_ as p,a as _,b as g}from"./TextInput-9a389ddf.js";import{_ as S}from"./PrimaryButton-6a1dffab.js";import"./ApplicationLogo-a5abaefc.js";const U=["value"],q={__name:"Checkbox",props:{checked:{type:[Array,Boolean],default:!1},value:{default:null}},emits:["update:checked"],setup(l,{emit:e}){const i=l,n=w({get(){return i.checked},set(t){e("update:checked",t)}});return(t,o)=>k((d(),h("input",{type:"checkbox",value:l.value,"onUpdate:modelValue":o[0]||(o[0]=b=>v(n)?n.value=b:null),class:"rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"},null,8,U)),[[x,s(n)]])}},L={key:0,class:"mb-4 font-medium text-sm text-green-600"},P=["onSubmit"],j={class:"mt-4"},D={class:"block mt-4"},E={class:"flex items-center"},F=r("span",{class:"ml-2 text-sm text-gray-600"},"Remember me",-1),M={class:"flex items-center justify-end mt-4"},H={__name:"Login",props:{canResetPassword:Boolean,status:String},setup(l){const e=y({email:"",password:"",remember:!1}),i=()=>{e.post(route("login"),{onFinish:()=>e.reset("password")})};return(n,t)=>(d(),u(R,null,{default:m(()=>[a(s(V),{title:"Log in"}),l.status?(d(),h("div",L,$(l.status),1)):c("",!0),r("form",{onSubmit:N(i,["prevent"])},[r("div",null,[a(p,{for:"email",value:"Email"}),a(_,{id:"email",type:"email",class:"mt-1 block w-full",modelValue:s(e).email,"onUpdate:modelValue":t[0]||(t[0]=o=>s(e).email=o),required:"",autofocus:"",autocomplete:"username"},null,8,["modelValue"]),a(g,{class:"mt-2",message:s(e).errors.email},null,8,["message"])]),r("div",j,[a(p,{for:"password",value:"Password"}),a(_,{id:"password",type:"password",class:"mt-1 block w-full",modelValue:s(e).password,"onUpdate:modelValue":t[1]||(t[1]=o=>s(e).password=o),required:"",autocomplete:"current-password"},null,8,["modelValue"]),a(g,{class:"mt-2",message:s(e).errors.password},null,8,["message"])]),r("div",D,[r("label",E,[a(q,{name:"remember",checked:s(e).remember,"onUpdate:checked":t[2]||(t[2]=o=>s(e).remember=o)},null,8,["checked"]),F])]),r("div",M,[l.canResetPassword?(d(),u(s(B),{key:0,href:n.route("password.request"),class:"underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"},{default:m(()=>[f(" Forgot your password? ")]),_:1},8,["href"])):c("",!0),a(S,{class:C(["ml-4",{"opacity-25":s(e).processing}]),disabled:s(e).processing},{default:m(()=>[f(" Log in ")]),_:1},8,["class","disabled"])])],40,P)]),_:1}))}};export{H as default};
