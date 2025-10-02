<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

$this->title = 'To-do List Application';
?>

<div class="todo-index">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>
        <p class="lead">Manage your tasks by category</p>
        
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Add New Task</h5>
                        <?php $form = ActiveForm::begin([
                            'id' => 'todo-form',
                            'action' => Url::to(['todo/create']),
                            'options' => ['class' => 'form-inline']
                        ]); ?>
                        
                        <div class="form-group mr-3">
                            <?= Html::dropDownList(
                                'Todo[category_id]', 
                                null, 
                                ArrayHelper::map($categories, 'id', 'name'),
                                ['class' => 'form-control', 'prompt' => 'Select Category', 'id' => 'category-select']
                            ) ?>
                        </div>
                        
                        <div class="form-group mr-3">
                            <?= Html::textInput('Todo[name]', '', [
                                'class' => 'form-control',
                                'placeholder' => 'What needs to be done?',
                                'id' => 'todo-name',
                                'required' => true
                            ]) ?>
                        </div>
                        
                        <div class="form-group">
                            <?= Html::submitButton('Add Task', [
                                'class' => 'btn btn-success',
                                'id' => 'add-btn'
                            ]) ?>
                        </div>
                        
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Your Tasks</h5>
                        <div class="table-responsive">
                            <table class="table table-hover" id="todo-table">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Task</th>
                                        <th>Category</th>
                                        <th>Created</th>
                                        <th width="100">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($todos)): ?>
                                    <tr id="empty-state">
                                        <td colspan="4" class="text-center text-muted">No tasks yet. Add one above!</td>
                                    </tr>
                                    <?php else: ?>
                                        <?php foreach ($todos as $todo): ?>
                                        <tr data-id="<?= $todo->id ?>">
                                            <td><?= Html::encode($todo->name) ?></td>
                                            <td><span class="badge badge-primary"><?= Html::encode($todo->category->name) ?></span></td>
                                            <td><?= Yii::$app->formatter->asDate($todo->timestamp, 'php:M j') ?></td>
                                            <td>
                                                <?= Html::button('Delete', [
                                                    'class' => 'btn btn-danger btn-sm delete-btn',
                                                    'data-id' => $todo->id
                                                ]) ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$createUrl = Url::to(['todo/create']);
$deleteUrl = Url::to(['todo/delete']);
$csrfParam = Yii::$app->request->csrfParam;
$csrfToken = Yii::$app->request->csrfToken;

$js = <<<JS
$(function() {
    const form = $('#todo-form');
    const tableBody = $('#todo-table tbody');
    const emptyStateRow = '<tr id="empty-state"><td colspan="4" class="text-center text-muted">No tasks yet. Add one above!</td></tr>';

    function showAlert(type, message) {
        $('.alert').remove();
        const alert = $(`
            <div class="alert alert-\${type} alert-dismissible fade show" role="alert">
                <strong>\${type === 'success' ? 'Success!' : 'Error!'}</strong> \${message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        `);
        $('.container').prepend(alert);
        setTimeout(() => alert.fadeOut(300, () => alert.remove()), 3000);
    }
   
    // code for add task
    form.on('submit', function(e) {
        e.preventDefault();
        $.post({
            url: '$createUrl',
            data: form.serialize(),
            dataType: 'json'
        }).done(function(res) {
            if (res.success) {
                showAlert('success', 'Task added successfully.');

                $('#empty-state').remove();

                const row = `
                    <tr data-id="\${res.todo.id}">
                        <td>\${res.todo.name}</td>
                        <td><span class="badge badge-primary">\${res.todo.category}</span></td>
                        <td>\${res.todo.timestamp}</td>
                        <td><button class="btn btn-danger btn-sm delete-btn" data-id="\${res.todo.id}">Delete</button></td>
                    </tr>
                `;
                tableBody.prepend(row);
                form[0].reset();
            }
        });
    });

    // code for delete task
    $(document).on('click', '.delete-btn', function() {
        const row = $(this).closest('tr');
        const id = $(this).data('id');

        $.post({
            url: '$deleteUrl?id=' + id,
            data: { '$csrfParam': '$csrfToken' }
        }).done(function(res) {
            if (res.success) {
                showAlert('success', 'Task deleted successfully.');
                row.fadeOut(300, function() {
                    $(this).remove();
                    if (tableBody.children().length === 0) {
                        tableBody.html(emptyStateRow);
                    }
                });
            }
        });
    });
});
JS;

$this->registerJs($js);
?>
