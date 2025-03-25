<?php
session_start();
require_once("../../Models/Admin/branches.class.php");
$branches = new Branches();

if(!empty($_GET['id']))
{
$user = $branches->getNoteId($_GET['id']);
// var_dump($user);
}

?>
<div class="ms-panel"  style="margin: 10px 50px 10px 50px;">
    <div class="ms-panel-header bg-light"><h3>Notes</h3></div>
        <div class="ms-panel-body">
            <form id="form_notes" method="post" autocomplete="false">
                <div class="form-body">

                    <div class="form-row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Type de Notes</label>
                                <input type="text" id="type" name="type" class="form-control" value="<?php if(!empty($_GET['id'])) echo $user->type;?>" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Details</label>
                                <textarea  id="descr" name="descr" class="form-control"><?php if(!empty($_GET['id'])) echo $user->descr;?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                        <?php
                        if(!empty($_GET['id']))
                            {
                                ?>
                                <input type="hidden" name="operation" id="operation" value="Edit" />
                                <input type="hidden" name="personne_id" id="person_id" value="<?php echo $_GET['id'];?>" />
                                <input id="Enregistrer" type="submit" class="btn btn-success" name="Enregistrer" value="Modifier"/>
                                <?php
                            }
                            else
                            {
                                ?>
                                <input type="hidden" name="operation" id="operation" value="Add" />
                                <input id="Enregistrer" type="submit" class="btn btn-success" name="Enregistrer" value="Enregistrer"/>
                                <?php
                            }
                            ?>
                    
                    <input id="tel_ut" type="hidden"  name="tel_ut" value="-"/>
                    <input id="email_ut" type="hidden"  name="email_ut" value="-"/>

                    
                 
                </div>
            </form>
            <div id="last_inserted"></div>
        </div>
</div>

<div style="padding-top: 20px;"></div>