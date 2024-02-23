<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>consent v2 iframe popup integration example</title>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/iframe-resizer/4.2.11/iframeResizer.js"></script>
    <script type="text/javascript" src="iframeresizer_setup.js"></script>
    <script type="text/javascript" src="form_setup.js"></script>

    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h2 style="text-align: center">consent v2 iframe popup integration example</h2>
    <form id="subscription-form">
        <input type="email" name="email" required />
        <button type="submit">subscribe</button>
    </form>
    <script>
        var form = document.getElementById('subscription-form');
        if (form.attachEvent) {
            form.attachEvent("submit", setupForm);
        } else {
            form.addEventListener("submit", setupForm);
        }
    </script>
</body>

</html>