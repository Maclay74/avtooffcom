<?php
    $user = User::getInstance();
echo includeJsFile("validate.js");
echo includeJsFile("agentForm.js");

?>
<div class="well offset2 span7">

    <form id = "agentForm" method="POST" action="?event=agent&action=form" class="form-horizontal">
        <fieldset>

            <!-- Form Name -->
            <legend class="text-center">Агент</legend>

            <!-- Text input-->
            <input id="id" name ="id" value="<?php echo $data[0]['id']; ?>" type="input" style="display:none" >
                <div class="control-group">
                <label class="control-label" for="second_name">ФИО</label>
                <div class="controls">
                    <input validatod="text" id="second_name" value="<?php echo $data[0]['second_name']; ?>" name="second_name" type="text" placeholder="" class="input-large" required="">
                    <i id="okay" style="display:none" class="icon-ok"></i>
                    <i id="remove" style="display:none" class="icon-remove"></i>
                </div>

            </div>



            <?php if (!isset($_GET['id'])):?>

            <!-- Text input-->
            <div class="control-group">
                <label class="control-label" for="login">Логин</label>
                <div class="controls">
                    <input  validatod="login" id="login" name="login" type="text" placeholder="" class="input-large" required="">
                    <i id="okay" style="display:none" class="icon-ok"></i>
                    <i id="remove" style="display:none" class="icon-remove"></i>
                </div>

            </div>

            <!-- Text input-->
            <div class="control-group">
                <label class="control-label" for="password">Пароль</label>
                <div class="controls">
                    <input  validatod="password" id="password" name="password" type="text" placeholder="" class="input-large" required="">
                    <i id="okay" style="display:none" class="icon-ok"></i>
                    <i id="remove" style="display:none" class="icon-remove"></i>
                </div>

            </div>
            <?php endif ?>


            <?php if ($user->type==1):?>

            <!-- Select Basic -->
            <div class="control-group">
                <label class="control-label" for="manager">Менеджер</label>
                <div class="controls">
                    <select id="manager" name="manager" class="input-xlarge">
                        <option>Will be</option>
                    </select>
                </div>
            </div>

            <?php endif ?>

            <?php echo $data[1]; ?>

            <div id = "newPrice" style="display:none">


                <!-- Text input-->
                <div class="control-group">
                    <label class="control-label" for="name">Название</label>
                    <div  class="controls">
                        <div class="input-append">
                            <input validatod="text" id="name" name="name" type="text" placeholder="" class="input-large" required="">
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
                            <input validatod="price" id="A"  name="A" class="input-medium" placeholder="" type="text" required="">
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
                            <input validatod="price" id="B" name="B" class="input-medium" placeholder="" type="text" required="">
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
                            <input validatod="price" id="C" name="C" class="input-medium" placeholder="" type="text" required="">
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
                            <input validatod="price" id="D" name="D" class="input-medium" placeholder="" type="text" required="">
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
                            <input validatod="price" id="E_light" name="E_light" class=" has-error input-medium" placeholder="" type="text" required="">
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
                            <input validatod="price" id="E_heavy" name="E_heavy" class="input-medium" placeholder="" type="text" required="">
                            <span class="add-on">рублей</span>
                        </div>
                        <i id="okay" style="display:none" class="icon-ok"></i>
                        <i id="remove" style="display:none" class="icon-remove"></i>
                    </div>
                </div>



            </div>
            <?php

            if (isset($data["error"])) {
                echo "<div class='alert alert-error'>";
                echo $data["error"];
                echo "</div>";
            }
            if (isset($_GET['id'])) {
                echo "<div class='alert alert-warning'>";
                echo "Изменение прайса вступит в силу только в 00:00 часов.";
                echo "</div>";
            }
             ?>

            <div class="control-group">

                <div <?php if (isset($_GET['id'])) echo "style='margin-left: 160px;'"; ?>  class="controls">
                    <a id="submit" name="submit" onclick="validateForm('agentForm',1);" class="btn btn-default">Сохранить</a>
                    <?php if (isset($_GET['id'])):?>
                        <a id="delete" name="delete" onclick="if(confirm('Удалить агента?')) window.location.href='?event=agent&action=delete&id=<?php echo $data[0]['id']?>' " class="btn btn-warning">Удалить</a>
                        <a id="delete" name="delete" onclick="if(confirm('Сбросить пароль?')) window.location.href='?event=agent&action=reset&id=<?php echo $data[0]['id']?>' " class="btn btn-warning">Сбросить пароль</a>
                    <?php endif ?>
                </div>
            </div>

        </fieldset>
    </form>

</div>


