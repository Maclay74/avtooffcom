<?php
    $user = User::getInstance();

echo includeJsFile("validate.js");


?>
<div class="well offset2 span7">

    <form id="priceForm" method="POST" Daction="?event=price&action=form" class="form-horizontal">
            <fieldset>

                <!-- Form Name -->
                <legend align="center">Прайс</legend>

                <!-- Text input-->
                <div class="control-group">
                    <label class="control-label" for="name">Название</label>
                    <div  class="controls">
                        <div class="input-append">
                          <input validatod="text" id="name" name="name" type="text" placeholder="" class="input-medium" required="">
                       </div>
                        <i id="okay" style="display:none" class="icon-ok"></i>
                        <i id="remove" style="display:none" class="icon-remove"></i>
                    </div>
                </div>

                <!-- Appended Input-->
                <div class="control-group">
                    <label class="control-label" for="A"> Категория А</label>
                    <div id="categoryA" class="controls">
                        <div class="input-append">
                            <input validatod="price" id="A"  name="A" class="input-small" placeholder="" type="text" required="">
                            <span class="add-on">рублей</span>

                        </div>
                        <i id="okay" style="display:none" class="icon-ok"></i>
                        <i id="remove" style="display:none" class="icon-remove"></i>
                    </div>
                </div>

                <!-- Appended Input-->
                <div class="control-group">
                    <label class="control-label" for="M1"> Категория B</label>
                    <div id="categoryB" class="controls">
                        <div class="input-append">
                            <input validatod="price" id="B" name="B" class="input-small" placeholder="" type="text" required="">
                            <span class="add-on">рублей</span>

                        </div>
                        <i id="okay" style="display:none" class="icon-ok"></i>
                        <i id="remove" style="display:none" class="icon-remove"></i>
                    </div>
                </div>

                <!-- Appended Input-->
                <div class="control-group">
                    <label class="control-label" for="M2"> Категория C</label>
                    <div id="categoryC" class="controls">
                        <div class="input-append">
                            <input validatod="price" id="C" name="C" class="input-small" placeholder="" type="text" required="">
                            <span class="add-on">рублей</span>
                        </div>
                        <i id="okay" style="display:none" class="icon-ok"></i>
                        <i id="remove" style="display:none" class="icon-remove"></i>
                    </div>
                </div>

                <!-- Appended Input-->
                <div class="control-group">
                    <label class="control-label" for="M3"> Категория D</label>
                    <div id="categoryD" class="controls">
                        <div class="input-append">
                            <input validatod="price" id="D" name="D" class="input-small" placeholder="" type="text" required="">
                            <span class="add-on">рублей</span>
                        </div>
                        <i id="okay" style="display:none" class="icon-ok"></i>
                        <i id="remove" style="display:none" class="icon-remove"></i>
                    </div>
                </div>

                <!-- Appended Input-->
                <div class="control-group">
                    <label class="control-label" for="M3">Легковой прицеп</label>
                    <div id="categoryE_light" class="controls">
                        <div class="input-append">
                            <input validatod="price" id="E_light" name="E_light" class=" has-error input-small" placeholder="" type="text" required="">
                            <span class="add-on">рублей</span>
                        </div>
                        <i id="okay" style="display:none" class="icon-ok"></i>
                        <i id="remove" style="display:none" class="icon-remove"></i>
                    </div>
                </div>

                <!-- Appended Input-->
                <div class="control-group">
                    <label class="control-label" for="M3">Грузовой прицеп</label>
                    <div id="categoryE_heavy" class="controls">
                        <div class="input-append">
                            <input validatod="price" id="E_heavy" name="E_heavy" class="input-small" placeholder="" type="text" required="">
                            <span class="add-on">рублей</span>
                        </div>
                        <i id="okay" style="display:none" class="icon-ok"></i>
                        <i id="remove" style="display:none" class="icon-remove"></i>
                    </div>
                </div>



                <!-- Button -->
                <div class="control-group">

                    <div  class="controls">
                        <a id="submit" name="submit" onclick="validateForm('priceForm',1)" class="btn btn-default">Сохранить</a>
                    </div>
                </div>

            </fieldset>
        </form>


</div>


