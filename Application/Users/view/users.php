<div id="jsUserApp" class="users">
    <h2><?php echo $title; ?></h2>
    <p><input class="form-control input-lg jsNew" type="text" placeholder="Add new..."></p>
    <div id="jsUsersList" class="list-group"></div>

    <script type="text/template" id="jsUserTemplate">
        <button type="button" class="close jsRemove"><span aria-hidden="true">&times;</span><span class="sr-only">Delete</span></button>
        <h4 class="list-group-item-heading">
            <span class="name jsName"><%- name %></span>
            <span class="badge"><%- groupsCount %></span>
        </h4>
        <p class="list-group-item-text hidden jsGroups">
            <span class="badge jsAddGroup">Add group</span>
        </p>
    </script>
    <script type="text/template" id="jsUserGroupTemplate">
        <span class="badge">
            <button type="button" class="close jsRemoveGroup"><span aria-hidden="true">&times;</span><span class="sr-only">Delete</span></button>
            <%- name %>
        </span>
    </script>
    <script>
        appUsersUrl = '<?php echo $urlAllData; ?>';
        appUsersDataUrl = '<?php echo $urlUserData; ?>';
    </script>
</div>
