<form method="post" action="<?= $this->url->href('TimeSpentPerUserController', 'showProjectChart',array('plugin' => 'TimeSpentChart','user_id'=>$selected_id)) ?>" autocomplete="off">
<?= $this->app->component('select-dropdown-autocomplete', array(
    'name' => 'boardId',
    'placeholder' => t($selected ? $selected : 'Users'),
    'items' => $users,
    'redirect' => array(
        'regex' => 'PROJECT_ID',
        'url' => $this->url->href('TimeSpentPerUserController', 'getProjects', array('plugin' => 'TimeSpentChart','user_id' => 'PROJECT_ID'))
    ),
    'onFocus' => array(
    'board.selector.open',
    )
)) ?>
<label>Projects</label>
    <select name="selected_project" >
        <option value="">select a project</option>
        <?php foreach ($paginator->getCollection() as $singleProject): ?>file_get_contents
          <?php echo "<option value=" . $singleProject['id'] . ">" .$singleProject['name']. "</option>" ?>
        <?php endforeach ?>
    </select>
<input type="hidden" name="test" value="".$selected_id>
<input type="submit" value="submit">
</form>
