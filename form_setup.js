async function setupForm(e) {

    if (e.preventDefault) e.preventDefault();

    const data = new FormData(e.target);
    let email = data.entries().next().value[1];

    const response = await fetch("get_form.php?uuid=" + email + "&email=" + email);

    var div = document.createElement("div");
    div.setAttribute("class", "iframe-ctn");
    document.body.appendChild(div);

    var ifrm = document.createElement("iframe");
    ifrm.setAttribute("src", response.url);
    ifrm.setAttribute("style", "position: absolute; width: 100%; height: 100%; overflow: hidden;");
    ifrm.setAttribute("scrolling", "no");
    ifrm.setAttribute("id", "consent");
    ifrm.setAttribute("name", "consent");
    ifrm.setAttribute("onload", "initIframeResizer('#consent');");

    div.appendChild(ifrm);
    return false;
}
