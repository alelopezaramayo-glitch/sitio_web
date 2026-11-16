document.addEventListener("DOMContentLoaded", () => {
  const saludo=()=>alert("¡Hola! Bienvenido a la sección de JavaScript.");
  window.setTimeout(saludo,150);
  document.querySelector("#saludo").addEventListener("click",saludo);

  const form=document.querySelector("#form-validacion");
  form.addEventListener("submit",e=>{
    e.preventDefault();
    const nombre=document.querySelector("#js-nombre").value.trim();
    const correo=document.querySelector("#js-correo").value.trim();
    const en=document.querySelector("#js-error-nombre"), ec=document.querySelector("#js-error-correo"), ok=document.querySelector("#js-ok");
    en.textContent=ec.textContent=ok.textContent="";
    let valido=true;
    if(!nombre){en.textContent="El nombre no puede estar vacío.";valido=false;}
    if(!correo){ec.textContent="El correo no puede estar vacío.";valido=false;}
    else if(!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(correo)){ec.textContent="Ingresá un correo válido.";valido=false;}
    if(valido)ok.textContent="Formulario válido.";
  });

  const actualizarReloj=()=>{const d=new Date();document.querySelector("#fecha").textContent=d.toLocaleDateString("es-ES");document.querySelector("#hora").textContent=d.toLocaleTimeString("es-ES");};
  actualizarReloj(); setInterval(actualizarReloj,1000);

  const toggle=document.querySelector("#toggle-menu"), menu=document.querySelector("#menu-js");
  toggle.addEventListener("click",()=>{const visible=menu.classList.toggle("visible");toggle.setAttribute("aria-expanded",visible);});

  const imgs=["assets/html.svg","assets/css.svg","assets/javascript.svg","assets/accesibilidad.svg"];
  const alts=["Imagen sobre HTML","Imagen sobre CSS","Imagen sobre JavaScript","Imagen sobre accesibilidad"];
  let i=0; const foto=document.querySelector("#foto-js"), grande=document.querySelector("#foto-grande");
  function render(){foto.src=imgs[i];foto.alt=alts[i];grande.style.display="none";}
  document.querySelector("#siguiente").addEventListener("click",()=>{i=(i+1)%imgs.length;render();});
  document.querySelector("#anterior").addEventListener("click",()=>{i=(i-1+imgs.length)%imgs.length;render();});
  document.querySelectorAll(".gallery-thumbs button").forEach(b=>b.addEventListener("click",()=>{i=Number(b.dataset.i);render();}));
  document.querySelector("#ampliar").addEventListener("click",()=>{grande.src=imgs[i];grande.alt=alts[i];grande.style.display="block";});

  document.querySelector("#tema").addEventListener("click",()=>document.body.classList.toggle("dark-mode"));

  document.querySelector("#resumen-form").addEventListener("submit",e=>{
    e.preventDefault();
    const n=document.querySelector("#r-nombre").value.trim(), edad=document.querySelector("#r-edad").value, email=document.querySelector("#r-email").value.trim();
    document.querySelector("#resumen-js").innerHTML=`<h3>Resumen de los datos</h3><p><strong>Nombre:</strong> ${n}</p><p><strong>Edad:</strong> ${edad}</p><p><strong>Correo:</strong> ${email}</p>`;
  });
});