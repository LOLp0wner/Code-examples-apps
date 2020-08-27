<!doctype html>
<html lang="en">
    <head>
    <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css2?family=Balsamiq+Sans&family=Comfortaa&family=Jura&family=Lobster&family=Noto+Serif&family=Old+Standard+TT&family=Play&family=Prosto+One&family=Russo+One&family=Source+Code+Pro&display=swap" rel="stylesheet"> 
        <link rel="stylesheet" href="jquery/jqui_rotate/jquery.ui.rotatable.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="jpicker/css/jPicker-1.1.6.css" type="text/css"/>
        
        <style>
        canvas {
            border: solid black 2px;
        }    
        font-family: 'Balsamiq Sans', cursive;
        font-family: 'Comfortaa', cursive;
        font-family: 'Jura', sans-serif;
        font-family: 'Lobster', cursive;
        font-family: 'Noto Serif', serif;
        font-family: 'Old Standard TT', serif;
        font-family: 'Play', sans-serif;
        font-family: 'Prosto One', cursive;
        font-family: 'Russo One', sans-serif;
        font-family: 'Source Code Pro', monospace;
        </style>
        <title>Watermarker</title>
    </head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"></button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <label class="btn btn-outline-info ml-3">
                    Загрузить ваш логотип<input type="file" class="" id="LogoLoad" hidden>
                    </label>
                </li>
                <li class="nav-item active">
                    <button type="button" class="btn btn-outline-dark ml-3" id="JSONlog">Получить разметку (JSON)</button>
                </li>
                <li class="nav-item active">
                    <button type="button" id="AddinText" class="btn btn-outline-info ml-3">Добавить текстовое поле</button>    
                </li>
            </ul>
        </div>
    </nav>
    <div class="container-fluid row">
        <div class="col-4 mt-4 mb-4 text-center">
            <h3>Видимость выбранного логотипа:</h3>
            <div id="alpha" class="mt-3"></div>
        </div>
        <div class="col-4 mt-4 mb-4 text-center" id="fontCh" style="visibility:hidden;">
            <h3>Выбор шрифта:</h3>
            <select name="textFont" id="textFont">
                <option value="Balsamiq Sans">Balsamiq Sans</option>
                <option value="Comfortaa">Comfortaa</option>
                <option value="Jura">Jura</option>
                <option value="Lobster">Lobster</option>
                <option value="Noto Serif">Noto Serif</option>
                <option value="Old Standard TT">Old Standard TT</option>
                <option value="Play">Play</option>
                <option value="Prosto One">Prosto One</option>
                <option value="Russo One">Russo One</option>
                <option value="Source Code Pro">Source Code Pro</option>
            </select>
        </div>
        <div class="col-4 mt-4 mb-4 text-center" id="colorCh" style="visibility:hidden;">
            <h4>Выбрать цвет текстового логотипа:</h4>
            <input id="Callbacks" type="text" value="e2ddcf" class="mt-1"/>
        </div>
    </div>
    
    <div class="container-fluid" >
        <div class="row justify-content-center">
            <canvas id="canvas" width="800" height="800"></canvas>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="jquery/jqui_rotate/jquery.ui.rotatable.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.0.0-beta.12/fabric.js"></script>
    <script src="jpicker/js/jpicker-1.1.6.js" type="text/javascript"></script>
    <script>
    
        var canvas = new fabric.Canvas('canvas');
        var imageUrl = './img/watermark.jpg'
        
        fabric.Image.fromURL(imageUrl, function(img){
            img.scaleToWidth(canvas.width);
            img.scaleToHeight(canvas.height);
            canvas.setBackgroundImage(img);
            canvas.requestRenderAll();
        });
        
        document.getElementById('LogoLoad').addEventListener("change", function (e) {
            var file = e.target.files[0];
            var reader = new FileReader();
            reader.onload = function (f) {
            var data = f.target.result;                    
            fabric.Image.fromURL(data, function (img) {
                var oImg = img.set({
                    angle: 0,
                    padding: 0,
                    cornersize:0,
                }).scale(0.9);
                    if (oImg.width >= canvas.width)
                    {
                        oImg.scaleToWidth(canvas.width); 
                    }
                    if (oImg.height >= canvas.height)
                    {
                        oImg.scaleToHeight(canvas.height);
                    }
                oImg.setControlsVisibility({
                    mt: false,
                    mb: false,
                    ml: false,
                    mr: false,
                });
                canvas.add(oImg).renderAll();
                var a = canvas.setActiveObject(oImg);
                var dataURL = canvas.toDataURL({format: 'png', quality: 1});
                });
            };
            reader.readAsDataURL(file);
        });
        
        $("#JSONlog").click(function() {
            var output_json = JSON.stringify(canvas);
            var i_output_json = JSON.parse(output_json);
            delete i_output_json.backgroundImage;
            $.each(i_output_json.objects, function(i, item) {
                delete i_output_json.objects[i].src;
            });
            window.open("data:text/json;charset=utf-8," + escape(JSON.stringify(i_output_json)));              
        });
        
        $("#alpha").slider({
            max: 1,
            min: 0,
            step: 0.1,
            value: 1,
            slide: function(event, ui) {
                canvas.getActiveObject() && (canvas.getActiveObject().opacity = ui.value)
                canvas.renderAll();
            },
            stop: function(event, ui) {
                canvas.renderAll();
            }
        });
        
        $("#AddinText").click( function() {
            var text = new fabric.IText('текст', {
                fontFamily: 'arial black',
                left: 100,
                top: 100,
                fill: "rgb(0,0,0)",
            });
            text.setControlsVisibility({
                mt: false,
                mb: false,
                ml: false,
                mr: false,
            });
            canvas.add(text);
            canvas.renderAll();
            canvas.setActiveObject(text);
            $('#fontCh').css('visibility', 'visible');
            $('#colorCh').css('visibility', 'visible'); 
        });
        
        $( "#textFont" ).selectmenu({    
            change: function( event, data ) {
                canvas.getActiveObject() && (canvas.getActiveObject().fontFamily = data.item.value)
                canvas.renderAll();
            }
        });
        
        $("#textFont").selectmenu({
            "position": {
                my: "left top",
                at: "left bottom",
                collision: "flip"
            } 
        });
       
        $('#Callbacks').jPicker(
        {
        window:{
            position:{x:'-50',y:'50'},
            expandable: false,
            liveUpdate: true}
        },
            function(color, context){
            var all = color.val('all');
            canvas.getActiveObject() && (canvas.getActiveObject().set("fill", "#" + all.hex))
            canvas.renderAll();
            console.log(all.hex.toString());
        });
    </script>
</body>
</html>
