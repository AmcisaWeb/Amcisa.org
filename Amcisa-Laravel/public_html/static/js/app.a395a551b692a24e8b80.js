webpackJsonp([1],{"+Gxq":function(t,e,n){"use strict";var s=n("fnDg").a;var a=n("VU/8")(s,null,!1,function(t){n("9YXS")},null,null);e.a=a.exports},"9M+g":function(t,e){},"9YXS":function(t,e){},"HUt/":function(t,e,n){"use strict";var s=n("qRo1").a;var a=n("VU/8")(s,null,!1,function(t){n("dIGf")},null,null);e.a=a.exports},IGUu:function(t,e){},JCpY:function(t,e,n){"use strict";var s=n("rKsW").a;var a=n("VU/8")(s,null,!1,function(t){n("hj9i")},null,null);e.a=a.exports},JDVb:function(t,e,n){"use strict";var s=n("9NuQ").a;var a=n("VU/8")(s,null,!1,function(t){n("itwp")},null,null);e.a=a.exports},JL9e:function(t,e){},Jmt5:function(t,e){},L6DT:function(t,e){},NHnr:function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var s=n("7+uW"),a={render:function(){this.$createElement;this._self._c;return this._m(0)},staticRenderFns:[function(){var t=this.$createElement,e=this._self._c||t;return e("nav",{staticClass:"nav-class"},[e("button",{staticClass:"bttn-stretch bttn-md bttn-primary"},[this._v("sdds")])])}]};var r=n("VU/8")(null,a,!1,function(t){n("uhcg")},null,null).exports,o=n("mtWM"),i=n.n(o),l={name:"App",data:function(){return{email:null,password:null}},methods:{handleLogin:function(){var t=this;i.a.create({headers:{"Content-Type":"application/json"}}).post("/oauth/token",{grant_type:"password",client_id:1,client_secret:"656qdZkintJzWSBKaaipFnRQzmP2SVrmdTPafbU5",username:this.email,password:this.password}).then(function(e){t.$store.commit("setToken",e.data.access_token)}).catch(function(e){alert("Password Error"),t.$store.commit("setToken",null),console.log(e)})},handleLogout:function(){this.$store.commit("setToken",null)}},created:function(){i.a.defaults.baseURL=this.$store.state.baseUrl}},c={render:function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"login-form"},[0==this.$store.state.currentUser.isLoggedIn?n("div",[n("el-input",{staticStyle:{width:"300px","margin-bottom":"10px"},attrs:{placeholder:"School Email"},model:{value:t.email,callback:function(e){t.email=e},expression:"email"}}),t._v(" "),n("br"),t._v(" "),n("el-input",{staticStyle:{width:"300px","margin-bottom":"10px"},attrs:{placeholder:"Password",type:"password"},model:{value:t.password,callback:function(e){t.password=e},expression:"password"}}),t._v(" "),n("br"),t._v(" "),n("el-button",{staticStyle:{width:"300px"},attrs:{type:"primary"},on:{click:function(e){t.handleLogin()}}},[t._v("LOGIN")]),t._v(" "),n("br"),t._v(" "),n("a",{attrs:{href:this.$store.state.baseUrl+"/password/reset"}},[t._v("Reset Password")])],1):n("div",[n("h5",[t._v("Hi! "+t._s(this.$store.state.currentUser.name_ch))]),t._v(" "),n("el-button",{attrs:{type:"primary"},on:{click:function(e){t.handleLogout()}}},[t._v("LOGOUT")])],1)])},staticRenderFns:[]};var u=n("VU/8")(l,c,!1,function(t){n("z6of")},"data-v-3046d6b0",null).exports,d={render:function(){this.$createElement;this._self._c;return this._m(0)},staticRenderFns:[function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"drop-down"},[e("p",[this._v("sdfsfs")])])}]};var p=n("VU/8")(null,d,!1,function(t){n("L6DT")},"data-v-6b621616",null).exports,m={name:"Events",data:function(){return{events:null}},methods:{handleClick:function(){this.$router.push("Event")}},watch:{isLogin:function(){var t=this;i.a.defaults.baseURL=this.$store.state.baseUrl,i.a.create({headers:{"Content-Type":"application/json",Authorization:"Bearer "+this.$store.state.currentUser.token}}).get("/api/event/get/*").then(function(e){t.events=e.data.events,console.log(t.events)}).catch(function(t){console.log(t)})}},computed:{isLogin:function(){return this.$store.state.currentUser.isLoggedIn}}},h={render:function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",t._l(t.events,function(e){return n("div",{staticStyle:{"max-width":"300px","margin-left":"auto","margin-right":"auto","margin-top":"50px"}},[n("el-card",{attrs:{"body-style":{padding:"0px"}}},[n("el-button",{staticClass:"button",attrs:{type:"text"},on:{click:function(e){t.handleClick()}}},[n("img",{staticClass:"image",attrs:{src:"http://localhost/api/download/15184543725198.jpeg"}}),t._v(" "),n("div",{staticStyle:{padding:"14px"}},[n("h3",[t._v(t._s(e.content.title))]),t._v(" "),n("div",{staticClass:"bottom clearfix"},[n("time",{staticClass:"time"},[t._v(t._s(e.content.description))])])])])],1)],1)}))},staticRenderFns:[]};var f=n("VU/8")(m,h,!1,function(t){n("iNre")},"data-v-4f0f49d6",null).exports,v={name:"AddEvent",data:function(){return{event:{title:"AmTee投票",thumbnail:"/path to thumbnail",description:"投选你最爱的AmTee设计！",fields:[{id:1,type:"selections_image",title:"Please Select",isInput:!0,selections:[{image:"/path to image 1",text:"text of image 1"},{image:"/path to image 2",text:"text of image 2"},{image:"/path to image 3",text:"text of image 3"}]},{type:"submit"}]}}},methods:{addEvent:function(){var t=this;i.a.create({headers:{"Content-Type":"application/json",Authorization:"Bearer "+this.$store.state.currentUser.token}}).post("/api/event/post",{event:this.event}).then(function(t){alert("successfully created events")}).catch(function(e){alert("Create event error"),console.log(t.event),console.log(e)})}},created:function(){i.a.defaults.baseURL=this.$store.state.baseUrl}},g={render:function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",[n("el-button",{on:{click:function(e){t.addEvent()}}})],1)},staticRenderFns:[]},_=n("VU/8")(v,g,!1,null,null,null).exports,U={data:function(){return{strData:'{"name": "AmTee",                 "id": "1",                 "state": "1",                 "description": "This is an event to submit T-shirt",                 "role": "member",                 "fill_in": [                    {"field":{"type": "description", "content": "Please elect the most Tee design U like!"}},                    {"field":{"type": "image", "content": "Design 1", "path": ""}},                    {"field":"sadasd"}                 ]}',xx:"",newTodoText:"",todos:[{id:1,title:"Do the dishes"},{id:2,title:"Take out the trash"},{id:3,title:"Mow the lawn"}],event_data:{name:"AmTee",id:"1",state:"1",description:"This is an event to submit T-shirt",role:"member",fill_in:[{field:{type:"description",content:"Please elect the most Tee design U like!"}},{field:{type:"description",content:"Please elect the most Tee design U like!"}},{field:{type:"description",content:"Please elect the most Tee design U like!"}}]},nextTodoId:4}},methods:{addNewTodo:function(){this.todos.push({id:this.nextTodoId++,title:this.newTodoText}),this.newTodoText=""}},components:{"todo-item":{template:"      <li>        {{ title }}        <button v-on:click=\"$emit('remove')\">X</button>      </li>      ",props:["title"]}},mounted:function(){console.log(JSON.parse(this.strData)),this.xx=JSON.parse(this.strData),prototype.$appName="My App",console.log(this.$appName)}},b={render:function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",[n("input",{directives:[{name:"model",rawName:"v-model",value:t.newTodoText,expression:"newTodoText"}],attrs:{placeholder:"Add a todo"},domProps:{value:t.newTodoText},on:{keyup:function(e){if(!("button"in e)&&t._k(e.keyCode,"enter",13,e.key))return null;t.addNewTodo(e)},input:function(e){e.target.composing||(t.newTodoText=e.target.value)}}}),t._v(" "),n("ul",t._l(t.todos,function(e,s){return n("todo-item",{key:e.id,tag:"li",attrs:{title:e.title},on:{remove:function(e){t.todos.splice(s,1)}}})})),t._v("\n  "+t._s(t.todos[0].title)+"\n  "+t._s(t.xx.name)+"\n  "+t._s(t.event_data.fill_in[0].field.type)+"\n")])},staticRenderFns:[]},x={name:"App",components:{"nav-bar":r,"login-form":u,informations:p,events:f,"add-event":_,backup:n("VU/8")(U,b,!1,null,null,null).exports},created:function(){i.a.defaults.baseURL=this.$store.state.baseUrl;var t=localStorage.getItem("token");null!=t&&this.$store.commit("setToken",t)}},y={render:function(){var t=this.$createElement,e=this._self._c||t;return e("div",{attrs:{id:"app"}},[e("router-view")],1)},staticRenderFns:[]};var T=n("VU/8")(x,y,!1,function(t){n("IGUu")},null,null).exports,w=n("/ocq"),$={name:"Home",data:function(){return{file:"",timer:""}},components:{"login-form":u,events:f,"add-event":_},methods:{submitFile:function(){var t=new FormData;t.append("file",this.file),t.append("extension","jpeg"),i.a.post("/api/upload",t,{headers:{"Content-Type":"multipart/form-data"}}).then(function(t){console.log(t)}).catch(function(){console.log("FAILURE!!")})},handleFileUpload:function(){this.file=this.$refs.file.files[0]}}},k={render:function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",[t._v("\n  Test\n  "),n("h1",{staticClass:"title",staticStyle:{"font-size":"6rem"}},[t._v("AMCISA")]),t._v(" "),n("login-form"),t._v(" "),n("events")],1)},staticRenderFns:[]};var I=n("VU/8")($,k,!1,function(t){n("UuYV")},"data-v-4384cf36",null).exports,A=n("eO45"),E={name:"Event",data:function(){return{vote:null,dataImages:[{id:"1",src:this.$store.state.baseUrl+"/api/download/1.jpg",alt:"Alt Image 1"},{id:"2",src:this.$store.state.baseUrl+"/api/download/2.jpg",alt:"Alt Image 2"},{id:"3",src:this.$store.state.baseUrl+"/api/download/3.jpg",alt:"Alt Image 3"},{id:"4",src:this.$store.state.baseUrl+"/api/download/4.jpg",alt:"Alt Image 4"},{id:"5",src:this.$store.state.baseUrl+"/api/download/5.jpg",alt:"Alt Image 5"},{id:"6",src:this.$store.state.baseUrl+"/api/download/6.jpg",alt:"Alt Image 6"},{id:"7",src:this.$store.state.baseUrl+"/api/download/7.jpg",alt:"Alt Image 7"},{id:"8",src:this.$store.state.baseUrl+"/api/download/8.jpg",alt:"Alt Image 8"}]}},components:{VueSelectImage:n.n(A).a},methods:{onSelectImage:function(t){this.vote=t.id},handleClick:function(){var t=this;null==this.vote?alert("请选择一种设计, 不要投废票Plsss~"):i.a.create({headers:{"Content-Type":"application/json",Authorization:"Bearer "+this.$store.state.currentUser.token}}).post("/api/amtee",{vote:this.vote}).then(function(e){alert("成功投票"),t.$router.push("/")}).catch(function(e){404==e.response.status?(alert("您已经投过票了"),t.$router.push("/")):(alert("Server Error"),console.log(e))})}},created:function(){i.a.defaults.baseURL=this.$store.state.baseUrl}},L={render:function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",[1==this.$store.state.currentUser.isLoggedIn?n("div",[n("h4",[t._v("请选择你爱的设计, 然后按“投票”. 一人只有一票~")]),t._v(" "),n("vue-select-image",{staticStyle:{margin:"10%","margin-bottom":"0","margin-top":"5%"},attrs:{dataImages:t.dataImages},on:{onselectimage:t.onSelectImage}}),t._v(" "),n("el-button",{staticStyle:{margin:"5%"},on:{click:function(e){t.handleClick()}}},[t._v("投票")])],1):n("div",[t._v("请返回主页登录")])])},staticRenderFns:[]},S=n("VU/8")(E,L,!1,null,null,null).exports;s.default.use(w.a);var C=new w.a({routes:[{path:"/",name:"Home",component:I},{path:"/Event",name:"Event",component:S}]}),R=n("NYxO");s.default.use(R.a);var V=new R.a.Store({state:{currentUser:{id:null,matric_no:null,email:null,name_en:null,name_ch:null,gender:null,course:null,birth_date:null,secondary_school:null,phone_sg:null,phone_my:null,university:null,token:null,isLoggedIn:!1},baseUrl:"http://amcisa.org"},mutations:{setToken:function(t,e){var n=this;null!=e?i.a.create({headers:{"Content-Type":"application/json",Authorization:"Bearer "+e}}).get(t.baseUrl+"/api/user").then(function(n){localStorage.setItem("token",e),t.currentUser.token=e,t.currentUser.isLoggedIn=!0,t.currentUser.matric_no=n.data.user.matric_no,t.currentUser.email=n.data.user.email,t.currentUser.name_en=n.data.user.name_en,t.currentUser.name_ch=n.data.user.name_ch,t.currentUser.gender=n.data.user.gender,t.currentUser.course=n.data.user.course,t.currentUser.birth_date=n.data.user.birth_date,t.currentUser.secondary_school=n.data.user.secondary_school,t.currentUser.phone_sg=n.data.user.phone_sg,t.currentUser.phone_my=n.data.user.phone_my,t.currentUser.university=n.data.user.university}).catch(function(t){alert("Password Error"),n.$store.commit("setToken",null),console.log(t)}):(localStorage.removeItem("token"),t.currentUser.matric_no=null,t.currentUser.email=null,t.currentUser.name_en=null,t.currentUser.name_ch=null,t.currentUser.gender=null,t.currentUser.course=null,t.currentUser.birth_date=null,t.currentUser.secondary_school=null,t.currentUser.phone_sg=null,t.currentUser.phone_my=null,t.currentUser.university=null,t.currentUser.token=null,t.currentUser.isLoggedIn=!1)}}}),j=n("zL8q"),F=n.n(j),N=n("e6fC");n("Jmt5"),n("9M+g"),n("tvR6");s.default.config.productionTip=!1,s.default.use(N.a),s.default.use(F.a),new s.default({el:"#app",router:C,store:V,components:{App:T},template:"<App/>"})},UuYV:function(t,e){},dIGf:function(t,e){},hj9i:function(t,e){},iNre:function(t,e){},itwp:function(t,e){},r15W:function(t,e,n){"use strict";var s=n("E9Zr").a;var a=n("VU/8")(s,null,!1,function(t){n("JL9e")},null,null);e.a=a.exports},tvR6:function(t,e){},uhcg:function(t,e){},z6of:function(t,e){}},["NHnr"]);
//# sourceMappingURL=app.a395a551b692a24e8b80.js.map