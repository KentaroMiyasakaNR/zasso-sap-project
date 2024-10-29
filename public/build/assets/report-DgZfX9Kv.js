if(typeof window.reportScriptLoaded>"u"){let n=function(t){console.log(`[DEBUG] ${t}`)},r=function(t){if(t.files&&t.files[0]){const o=new FileReader;o.onload=function(e){u.src=e.target.result,v.style.display="block"},o.readAsDataURL(t.files[0])}},g=function(t){if(t.preventDefault(),console.log("同定分析analyzeImage called"),!l.files||l.files.length===0){d.innerHTML="<p>写真を選択してください。</p>";return}document.getElementById("loadingModal").style.display="block";const o=new FormData(c);fetch(c.action,{method:"POST",body:o,headers:{"X-CSRF-TOKEN":document.querySelector('meta[name="csrf-token"]').content}}).then(e=>(console.log("Response status:",e.status),console.log("Response headers:",e.headers),e.json())).then(e=>{console.log("サーバーからの応答:",e),document.getElementById("loadingModal").style.display="none",e&&e.content?(d.innerHTML=`<pre>${e.content}</pre>`,p.style.display="inline-block"):(console.error("予期しないデータ構造:",e),d.innerHTML="<p>データの取得に失敗しました。もう一度お試しください。</p>")}).catch(e=>{console.error("エラー:",e),document.getElementById("loadingModal").style.display="none",d.innerHTML="<p>エラーが発生しました。もう一度お試しください。</p>"})},y=function(){w.src=u.src,f.style.display="block"},s=function(){f.style.display="none"},B=function(){const t=new FormData;t.append("photo",l.files[0]),t.append("identification_result",d.innerText),"geolocation"in navigator?navigator.geolocation.getCurrentPosition(function(o){t.append("latitude",o.coords.latitude),t.append("longitude",o.coords.longitude),i(t)},function(o){console.error("位置情報の取得に失敗しました:",o),i(t)}):i(t)},i=function(t){const o=document.querySelector('meta[name="csrf-token"]').getAttribute("content");fetch(reportStoreUrl,{method:"POST",body:t,headers:{"X-CSRF-TOKEN":o}}).then(e=>e.json()).then(e=>{console.log("記録が送信されました:",e),alert("記録が正常に送信されました。"),s()}).catch(e=>{console.error("記録の送信中にエラーが発生しました:",e),alert("記録の送信中にエラーが発生しました。もう一度お試しください。")})},h=function(){n("Initializing event listeners"),m.addEventListener("click",function(){n("selectPhotoBtn clicked"),l.click()}),l.addEventListener("change",function(){n("File selected: "+(this.files[0]?this.files[0].name:"No file")),r(this)}),c.addEventListener("submit",g),p.addEventListener("click",y),k.addEventListener("click",s),L.addEventListener("click",B),n("Event listeners initialized")},E=function(){n("Checking elements"),n("selectPhotoBtn: "+(m?"Found":"Not found")),n("photoInput: "+(l?"Found":"Not found")),n("uploadForm: "+(c?"Found":"Not found")),n("analyzeBtn: "+(I?"Found":"Not found"))},a=function(){n("DOMContentLoaded event fired"),E(),h()};var F=n,S=r,M=g,P=y,R=s,D=B,T=i,b=h,z=E,N=a;window.reportScriptLoaded=!0;const u=document.getElementById("preview"),v=document.getElementById("imagePreview"),c=document.getElementById("uploadForm"),d=document.getElementById("result"),l=document.getElementById("photo"),m=document.getElementById("selectPhotoBtn"),I=document.getElementById("analyzeBtn"),p=document.getElementById("reportBtn"),f=document.getElementById("reportModal"),w=document.getElementById("modalPreview"),L=document.getElementById("confirmReportBtn"),k=document.getElementById("cancelReportBtn");document.readyState==="loading"?document.addEventListener("DOMContentLoaded",a):a(),window.previewImage=r,n("Script loaded")}else console.warn("Report script already loaded. Skipping re-initialization.");