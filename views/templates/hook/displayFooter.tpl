{*
*
*  ██████  ██  ██████  ██████  ██████   ██████  ██   ██
*  ██   ██ ██ ██    ██ ██   ██ ██   ██ ██    ██  ██ ██
*  ██████  ██ ██    ██ ██████  ██████  ██    ██   ███
*  ██   ██ ██ ██    ██ ██      ██   ██ ██    ██  ██ ██
*  ██████  ██  ██████  ██      ██   ██  ██████  ██   ██
*
* @author BIOPROX <juanfer@bioprox.es>
* @copyright 2022 BIOPROX LABORATORIOS S.C.A.
*}
<!-- Block leycookies -->
<style>
  /* ESTILO: VENTANA FLOTANTE */
  #bpxlabs-cookies {
    position: fixed;
    width: 420px;
    z-index: 9999999;
    bottom: 10px;
    left: 10px;
  }

  #bpxlabs-container {
    background-color: rgba(0, 0, 0, 0.8);
    color: #fff;
    padding: 20px 26px;
    box-sizing: border-box;
    border-radius: 6px;
    display: flex;
    width: 100%;
    flex-direction: column;
    align-items: center;
  }

  #bpxlabs-header {}

  #bpxlabs-message {
    text-align: justify;
  }

  #bpxlabs-button {
    align-self: center;
    margin-top: 10px;
  }

  .btn-outline-warning {
    color: {$color};
    background-image: none;
    background-color: transparent;
    border-color: {$color};
  }

  .btn-outline-warning:hover {
    color: #fff;
    background-color: {$color};
    border-color: {$color};
  }

  a:link,
  a:visited {
    color: {$color};
    text-decoration: none;
  }

  a:hover,
  a:active {
    text-decoration: underline;
  }

  /* ESTILO: FOOTER */
  /*  
  #bpxlabs-cookies {
    text-align: center;
    background-color: rgba(0, 0, 0, 0.8);
    color: #fff;
    z-index: 10000;
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    padding: 1rem 1rem 1rem 1rem;
  }
  .btn-outline-warning {
color: {$color};
  background-image: none;
  background-color: transparent;
  border-color: {$color};
  }

  .btn-outline-warning:hover {
    color: #fff;
    background-color: {$color};
    border-color: {$color};
  }

  a:link,
  a:visited {
    color: {$color};
    text-decoration: none;
  }

  a:hover,
  a:active {
    text-decoration: underline;
  }

  #bpxlabs-header {}

  #bpxlabs-content {
    display: flex;
    width: 100%;
  }

  #bpxlabs-button {
    width: 25%;
    display: flex;
  }

  */
</style>


<div id="bpxlabs-cookies">
  <div id="bpxlabs-container">

    <div id="bpxlabs-header">
      <h4>
        {if $imagen eq 1}
          <img src="modules/bpxleydecookies/views/img/cookie1.png" width="40">
        {elseif $imagen eq 2}
          <img src="modules/bpxleydecookies/views/img/cookie2.png" width="40">
        {elseif $imagen eq 3}
          <img src="modules/bpxleydecookies/views/img/cookie3.png" width="40">
        {elseif $imagen eq 4}
          <img src="modules/bpxleydecookies/views/img/cookie4.png" width="40">
        {elseif $imagen eq 5}
          <img src="modules/bpxleydecookies/views/img/cookie5.png" width="40">
        {elseif $imagen eq 6}
          <img src="modules/bpxleydecookies/views/img/cookie6.png" width="40">
        {elseif $imagen eq 7}
          <img src="modules/bpxleydecookies/views/img/cookie7.png" width="40">
        {elseif $imagen eq 8}
          <img src="modules/bpxleydecookies/views/img/cookie8.png" width="40">
        {/if}
        {$header}
      </h4>
    </div>

    <div id="bpxlabs-message">{$mensaje} <a href="{$link}" target="_blank">Ver
        la política de
        cookies.</a>
    </div>

    <div id="bpxlabs-button">
      <button type="button" class="btn btn-outline-warning btn-sm" onclick="aceptarCookies()"><i
          class="material-icons">done</i> ACEPTAR</button>
      {*<button type="button" class="btn btn-outline-warning btn-sm"><i class="material-icons">tune</i>Configurar</button>*}
    </div>
  </div>

</div>


<script>
  //Crear una cookie en JS
  function setCookie(cname, cvalue, expiredays) {
    let d = new Date();
    d.setTime(d.getTime() + (expiredays * 24 * 60 * 60 * 1000));
    let expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
  }
  //Obtener datos de una cookie
  function getCookie(cname) {
    let name = cname + "=";
    let ca = document.cookie.split(';');
    for (let i = 0; i < ca.length; i++) {
      let c = ca[i];
      while (c.chartAt(0) == ' ')
        c = c.substring(1);
      if (c.indexOf(name) == 0)
        return c.substring(name.length, c.length);
    }
    return "";
  }
  //Comprobar si existe una cookie
  function checkCookie(cname) {
    let encontrado = false;
    let cvalue = getCookie(cname);
    if (cvalue != "") {
      encontrado = true;
    }
    return encontrado;
  }
  //Eliminar una cookie
  function eliminarCookie(cname) {
    return document.cookie = cname + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;';
  }
  //onclick boton
  function aceptarCookies() {
    cookiename = "bpxleydecookies";
    cookievalue = true;
    expiredays = 365 * 2;
    setCookie(cookiename, cookievalue, expiredays);
    $("#bpxlabs-cookies").hide();
    alert(document.cookie);
  }
</script>
<!-- /Block leycookies -->