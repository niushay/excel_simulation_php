$(document).ready(function() {
    var url = "http://localhost/excel_simulation/"

    // Add row button
    $("#addNewRow").click(function(){
        let lastRowNumber = Number($("#dataTable tr:last th").text());
        let numberOfColumns = $("#dataTable tr:last td ,#dataTable tr:last th").length;

        //Added row Template
        let rowTemplate = '<tr>' +'<th scope="row">' + (lastRowNumber + 1) +'</th>';
        for(let i = 0; i<numberOfColumns-1; i++ ){
            rowTemplate += '<td contenteditable="true">Text</td>'
        }
        rowTemplate + '</tr>';

        $('#dataTable > tbody:last-child').append(rowTemplate)
    });

    //Add column button
    $("#addNewColumn").click(function(){
        let lastColumnNumber = $("#dataTable tr:nth-child(2) th:last-child").text()
        lastColumnNumber++

        $('#dataTable tr').each(function(key) {
            if(key===0){
                $(this).append('<th></th>');
            }else if(key===1){
                $(this).append("<th>" + lastColumnNumber + "</th>");
            }else{
                $(this).append('<td contenteditable="true">Text</td>');
            }
        });

        $("#firstHeader").attr('colSpan', lastColumnNumber + 1);
        $("#firstHeader+ th").remove();
    });

    //Add new sheet
    $("#addNewSheet").click(function(){
        let lastColumnNumber = $("#sheetTable td").length
        lastColumnNumber++
        console.log(lastColumnNumber)

        $('#sheetTable tr').each(function(key) {
            if(key===0){
                $(this).append("<th></th>");
            }else{
                $(this).append('<td><a href='+lastColumnNumber+'>sheet ' + lastColumnNumber + '</a></td>');
            }
        });

        $("#excelSheetFirstHeader").attr('colSpan', lastColumnNumber + 1);
        $("#excelSheetFirstHeader+ th").remove();

        $.post( url + "pages/createSheet", { sheet: lastColumnNumber}).done(function( data ) {
        })

    })

    //Save changes
    $("#save").click(function() {
        var url = window.location.href
        var sheetNumber = url.split("/").slice(-1).join("/");

        if(sheetNumber === "")
            sheetNumber = 1;
        let colArray = [];

        $('#dataTable tr').each(function (index, tr) {
            let cols = [];
            if(index === 0 || index === 1){
                return;
            }
            //get td of each row and insert it into cols array
            $(this).find('td').each(function (colIndex, c) {
                cols.push(c.textContent);
            });
            colArray.push(cols)
        });

        $.post(  url + "pages/store", { data: colArray, sheet: sheetNumber})
            .done(function() {
                alert('Data has been successfully saved!')
            });
    })
});