<?php require_once 'header.php'?>
<?php $columnNumbers = $data['numberOfCols']?>
<div class="container" style="margin-top: 3%" xmlns="http://www.w3.org/1999/html">
    <div class="row justify-content-start">
        <div class="col-md-9">
            <table class="table table-borderless table-bordered table-responsive table-sm" id="dataTable">
                <thead>
                    <tr>
                        <th id="firstHeader" scope="col" colspan="<?= $columnNumbers ?>">Excel sheet</th>
                    </tr>
                    <tr>
                        <th></th>
                        <? if($data['items'] !== '') { ?>
                            <?php for($i = 0; $i < count((array)$data['items'][0]) - 1; $i++): ?>
                                <th><?php echo $i + 1?> </th>
                            <?php endfor;?>
                        <? } ?>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($data['items'] as $key => $item): ?>
                    <tr>
                        <th scope="row" ><?= $key + 1 ?></th>
                        <?php foreach ($item as $k=>$v): ?>
                             <?php if($k == 'id') continue ?>
                            <td contenteditable="true"><?= $v ?></td>
                        <?php endforeach;?>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>

        </div>
        <div class="col-md-1"></div>
        <div class="col-md-2">
            <button class="btn btn-outline-primary float-end" id="addNewColumn">
                Add column
            </button>
        </div>
    </div>

    </br>
    </br>

    <div class="row justify-content-start">
        <!--add row button-->
            <div class="col-md-5 ">
                <button class="btn btn-outline-primary" id="addNewRow">
                    Add Row
                </button>
            </div>
            <div class="col-md-2"></div>
            <div class="col-md-5 ">
                <button class="btn btn-outline-primary float-end" id="save">
                    save
                </button>
            </div>
    </div>

    </br>
    </br>
    <!--Table of sheets-->
    <div class="row" id="sheetTable">
        <div class="col-md-4">
            <table class="table table-borderless table-bordered">
                <thead >
                <tr>
                    <th scope="col" colspan="4" id="excelSheetFirstHeader">Excel sheet</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><a href="#">sheet 1</a></td>
                    <td><a href="#">sheet 2</a></td>
                    <td><a href="#">sheet 3</a></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    </br>
    </br>

    <!--add new sheet button-->
    <div class="row">
        <div class="col-md-4">
            <button class="btn btn-outline-primary" id="addNewSheet">
                Add new sheet
            </button>
        </div>
    </div>

</div>

<script>
    $(document).ready(function() {
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

            $('#sheetTable tr').each(function(key) {
               if(key===0){
                    $(this).append("<th></th>");
                }else{
                    $(this).append('<td>sheet ' + lastColumnNumber + '</td>');
                }
            });

            //merge columns in the header
            $("#excelSheetFirstHeader").attr('colSpan', lastColumnNumber + 1);
            $("#excelSheetFirstHeader+ th").remove();
        })

        //Save changes
        $("#save").click(function() {
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

            $.post( "pages/store", { data: colArray, sheet: 1})
                .done(function( data ) {
                    // if(status === true)
                    //     alert(data['message']);
                });
        })
    });
</script>


<?php require_once 'footer.php'?>
