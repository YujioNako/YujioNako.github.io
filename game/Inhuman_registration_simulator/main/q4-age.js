let activate4=()=>{let e,t,n,a,o,u;function r(){rotation=45*(e.value/e.max-t.value/t.max),rotation=function(e,t,n){e<t?e=t:e>n&&(e=n);return e}(rotation,-45,45),n.style.transform=`rotate(${rotation}deg)`,n.value=parseInt(n.value)+Math.round(rotation),a.innerText=Math.round(n.value/100),age=Math.round(n.value/100),ageLabel.innerHTML=age}function l(){return Math.round(Math.random())?1:-1}function i(){o=u=l()}n=document.getElementById("volumeBar"),e=document.getElementById("sliderLeft"),t=document.getElementById("sliderRight"),a=document.getElementById("volumeDisplay"),i(),setInterval((function(){i()}),1e4),setInterval((function(){e.value=parseInt(e.value)+1*o,t.value=parseInt(t.value)+1*u,r(),r()}),Math.round(10))};