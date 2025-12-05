<?php
$title = "Mitglieder";
$add = "create";
require __DIR__ . "/../layout/topIndex.php"
?>

<link rel="stylesheet" href="/css/user.css">

<div id="userList">
    <?php foreach ($users as $user):?>
        <?php
            $self = $user["id"] === $_SESSION["user_id"];
        ?>
        <user <?php if ($self) echo 'class="self"'?>>
            <div class="infos">
                <div class="title">
                    <h3><?=htmlspecialchars($user["name"] ?? "")?></h3>
                    <p><i><?=htmlspecialchars($user["username"] ?? "")?></i></p>
                </div>
                <p><?=htmlspecialchars($user["instrument"] ?? "")?></p>
            </div>
            <?php if ($self) echo '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil"><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/><path d="m15 5 4 4"/></svg>'?>
        </user>
    <?php endforeach;?>
</div>

<script>
    $(".self").off().click(function() {
        window.location.assign("/account/edit");
    });
</script>