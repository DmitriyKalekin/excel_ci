<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// http://makitweb.com/make-live-editable-table-with-jquery-ajax/
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Разметка интентов</title>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <style>
        .edit{
        /*width: 100%;
        height: 25px;*/


        }
        .editMode{
            border: 1px solid rgb(66, 139, 202);
            -webkit-box-shadow: 3px 3px 5px 6px #ccc;  /* Safari 3-4, iOS 4.0.2 - 4.2, Android 2.3+ */
            -moz-box-shadow:    3px 3px 5px 6px #ccc;  /* Firefox 3.5 - 3.6 */
            box-shadow:         3px 3px 5px 6px #ccc;
            background: #fff;
        }

        td:focus {
            border: 1px solid rgb(66, 139, 202);
            -webkit-box-shadow: 3px 3px 5px 6px #ccc;  /* Safari 3-4, iOS 4.0.2 - 4.2, Android 2.3+ */
            box-shadow:         3px 3px 5px 6px #ccc;
              -moz-box-shadow:    3px 3px 5px 6px #ccc;  /* Firefox 3.5 - 3.6 */
            background: #fff;

        }

        /* Table Layout
        table {
        border:3px solid lavender;
        border-radius:3px;
        }*/

        table th{
            background-color:rgb(66, 139, 202);
        }
        table tr:nth-child(1) th{
        color:white;
        /*padding:10px 0px;*/
        letter-spacing: 1px;
        }

        /* Table rows and columns
        table td{
        padding:10px;
        }*/
        table tr:nth-child(even){
            background-color:#f0ffff;
            color:black;
        }

        table tr:nth-child(odd){
            background-color:#fffff0;
            color:black;
        }

        table {
            margin: 0;

        }

        thead {
            margin: 0;

        }

        td {
            border: 1px solid #aeaeae;

        }

        .panel-heading {
            padding-bottom: 22px;
        }
</style>

</head>
<body>
<?php
function show_content($messages)
{
    echo "<div id=\"container\" class=\"container\">";
        echo "<h3 id=\"id_h3\">Разметка интентов</h3>";
        echo "<hr>";
        echo "<div class=\"row\">";
            echo "<div class=\"panel panel-primary filterable\">";
                echo "<div class=\"panel-heading\">";
                    echo "<h3 class=\"panel-title\">Сообщения</h3>";
                    echo "<div class=\"pull-right\">";
                        echo "<button class=\"btn btn-default btn-xs btn-filter\"><span class=\"glyphicon glyphicon-filter\"></span> Filter</button>";
                    echo "</div>";
                echo "</div>";
                echo "<table class=\"table\">";
                    echo "<thead>";
                        echo "<tr class=\"filters\">";
                            echo "<th><input type=\"text\" class=\"form-control\" placeholder=\"intent\" disabled></th>";
                            echo "<th><input type=\"text\" class=\"form-control\" placeholder=\"Message\" disabled></th>";
                            echo "<th><input type=\"text\" class=\"form-control\" placeholder=\"noun\" disabled></th>";
                            echo "<th><input type=\"text\" class=\"form-control\" placeholder=\"verb\" disabled></th>";
                            echo "<th><input type=\"text\" class=\"form-control\" placeholder=\"md\" disabled></th>";
                            echo "<th><input type=\"text\" class=\"form-control\" placeholder=\"wrb\" disabled></th>";
                            echo "<th></th>";
                            echo "<th></th>";
                        echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";



                    foreach ($messages as $rec)
                    {
                        echo "<tr data-id=\"{$rec->id}\">";
                            echo "<td contentEditable='true' class=\"edit\" data-name=\"intent\">{$rec->intent}</td>";
                            echo "<td contentEditable='true' class=\"edit\" data-name=\"msg\">{$rec->msg}</td>";
                            echo "<td contentEditable='true' class=\"edit\" data-name=\"noun\">{$rec->noun}</td>";
                            echo "<td contentEditable='true' class=\"edit\" data-name=\"verb\">{$rec->verb}</td>";
                            echo "<td contentEditable='true' class=\"edit\" data-name=\"md\">{$rec->md}</td>";
                            echo "<td contentEditable='true' class=\"edit\" data-name=\"wrb\">{$rec->wrb}</td>";
                            echo "<td><p data-placement=\"top\" data-toggle=\"tooltip\" title=\"Edit\"><button class=\"btn btn-primary btn-xs\" data-title=\"Edit\" data-toggle=\"modal\" data-target=\"#edit\" ><span class=\"glyphicon glyphicon-pencil\"></span></button></p></td>";
                            echo "<td><p data-placement=\"top\" data-toggle=\"tooltip\" title=\"Delete\"><button class=\"btn btn-danger btn-xs\" data-title=\"Delete\" data-toggle=\"modal\" data-target=\"#delete\" ><span class=\"glyphicon glyphicon-trash\"></span></button></p></td>";
                        echo "</tr>";
                    }

                    echo "</tbody>";
                echo "</table>";
            echo "</div>";
        echo "</div>";

    echo "</div>";

}

show_content($messages);

?>
<script>
$(document).ready(function(){
    var old_value = "Old None value!!!!!%^&^*@&^@"; // сюда запоминаем старое значение ячейки

    // смена класса текущей редактируемой ячейки
    $('.edit').click(function(){
        $(this).addClass('editMode');
        var id = this.parentNode.getAttribute("data-id"); // id записи (в строке)
        var value = $(this).text();                       // текст внутри ячейки
        var name = this.getAttribute("data-name");        // имя поля
        old_value = id + "_" + value + "_" + name;        // запомнили старое значение, чтобы его не отправлять
    }); // edit click

    // Save data
    $(".edit").focusout(function(){
        $(this).removeClass("editMode");
        var id = this.parentNode.getAttribute("data-id");
        var value = $(this).text();
        var name = this.getAttribute("data-name");

        // Посылаем только в том случае, если в ячейке изменилось значение
        if (id + "_" + value + "_" + name != old_value)
        {
            $.ajax({
                url: 'update.php',
                type: 'post',
                data: { id: id, val: value, name: name},
                success: function(response){
                    var obj = response; //JSON.parse(response);
                    console.log(obj);
                } // success
            }); // ajax
        } // if
    }); // edit focusout

    var elem = document.getElementById('id_h3');
    document.getElementById('id_h3').style.color = '#ff0000';
    var elems = document.getElementsByClassName('edit');

    for (var i =0; i<elems.length; i++)
    {
        //console.log(elems[i]);
        //elems[i].style.color = "#00ff00";
        //elems[i].innerHTML
    }

    $('.edit').each(function (el) {
        //console.log(el);

    });
    // xPath
    //$('.edit')
    // jQuery('#id_h3')

    elem.addEventListener('click', function (){
        elem.style.color = '#00ff00';
    });

    elem.addEventListener('click', function (){
        alert('clicked - alert second');
    });


}); // ready
</script>
</body>
</html>
