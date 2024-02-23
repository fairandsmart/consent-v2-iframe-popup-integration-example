let iFrameResizeAlreadyInitialized;

function initIframeResizer(frameName) {

    if (!iFrameResizeAlreadyInitialized) {
        iFrameResizeAlreadyInitialized = true;
        iFrameResize({
            log: false,
            heightCalculationMethod: "max",
            onMessage: function (e) {
                const msg = e.message;
                if (msg.indexOf('consent-callback') > -1) {
                    const urlback = msg.replace('consent-callback/', '');
                    document.location = urlback;
                }
                return
            },
            onClose: function () { // avoid internal callback handling disruption
                return false;
            },
        }, frameName);
    }
}
