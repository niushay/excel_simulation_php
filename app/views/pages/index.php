<?php require_once 'header.php'?>

<?php $columnNumbers = $data['numberOfCols']?>
<?php $url = $_SERVER['REQUEST_URI']?>
<?php $parts= explode("/", $url); $pageNumber = end($parts); if ($pageNumber=='') $pageNumber = 1;?>

<div class="container" style="margin-top: 3%" >
    <div class="" style="display: flex">
        <div class="col-md-7" >
            <table class="table table-borderless table-bordered table-responsive table-sm" id="dataTable">
                <thead>
                    <tr>
                        <th class="table-success" id="firstHeader" scope="col" colspan="<?= $columnNumbers ?>">Excel sheet</th>
                    </tr>

                    <tr>
                        <th style="width: 20%"></th>
                        <? if($data['items'] !== '') { ?>
                            <?php for($i = 0; $i < count((array)$data['items'][0]) - 1; $i++): ?>
                                <th style="width: 20%"><?php echo $i + 1?> </th>
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
        <div class="col-md-2"></div>
        <div class="col-md-2">
            <button class="btn btn-success float-end" id="addNewColumn">
                Add column
            </button>
        </div>
    </div>

    </br>
    </br>

    <div class="row justify-content-start">
        <!--add row button-->
            <div class="col-md-7 ">
                <button class="btn btn-success" id="addNewRow">
                    Add Row
                </button>
            </div>
            <div class="col-md-2"></div>
            <div class="col-md-2 ">
                <button class="btn btn-success float-end" id="save">
                    save
                </button>
            </div>
    </div>

    </br>
    </br>
    <!--Table of sheets-->
    <div class="row" id="sheetTable">
        <div class="col-md-3">
            <table class="table table-borderless table-bordered">
                <thead >
                <tr>
                    <th scope="col" colspan="<?php echo sizeof($data['sheets'])?>" id="excelSheetFirstHeader">Excel sheet</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php foreach ($data['sheets'] as $sheet):?>
                            <td class="<?=$pageNumber === $sheet['sheet'] ? 'salam' : ''?>"><a "  href="<?php echo $sheet['sheet']?>">sheet <?php echo $sheet['sheet']?></a></td>
                        <?php endforeach;?>
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
            <button class="btn btn-success" id="addNewSheet">
                Add new sheet
            </button>
        </div>
    </div>

</div>

<script type="application/javascript" src="<?php echo URLROOT . 'public/javascript/javascript.js'?>"></script>

<?php require_once 'footer.php'?>
