<?php $this->assign('title', 'Turmas'); ?>
<?php $this->start('breadcrumb'); ?>
<li><?= $this->Html->link('<i class="fa fa-dashboard"></i>' . __('Dashboard'), '/', ['escape' => false]) ?></li>
<li class="active">Lista de turmas</li>
<?php $this->end(); ?>

<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary <?= !$isFiltered ? 'collapsed-box' : '' ?>">
            <div class="box-header with-border">
                <button class="btn btn-primary btn-xs pull-left" style="margin-right: 5px" data-widget="collapse" data-original-title="Collapse">
                    <i class="fa <?= !$isFiltered ? 'fa-plus' : 'fa-minus' ?>"></i>
                </button>

                <h3 class="box-title" style="vertical-align: middle"> <?= __('Filtros') ?></h3>
            </div>

            <?= $this->Form->create(null, ['type' => 'get']) ?>
            <div class="box-body" <?= !$isFiltered ? 'style="display: none;"' : '' ?>>
                <div class="row">
                    <div class="col-lg-9 col-sm-12">
                        <div class="row">
                            <div class="col-sm-4">
                                <?= $this->Form->input('status', ['label' => __("Status"), 'options' => $status]) ?>
                            </div>
                            <div class="col-sm-4">
                                <?=	$this->Form->input('process', ['label' => __('Processo de distribuição'), 'options' => $processes]) ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $this->Form->input('subject', ['label' => __('Disciplina'), 'options' => $subjects]) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <?= $this->Form->input('knowledge', ['label' => __('Núcleo de conhecimento'), 'options' => $knowledges]) ?>
                            </div>
                            <div class="col-sm-8">
                                <?= $this->Form->input('teachers[]', ['label' => __('Docentes alocados'), 'options' => $teachers,
                                    'multiple', 'data-placeholder' => 'Selecione o docente', 'class' => 'select2']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer" <?= !$isFiltered ? 'style="display: none;"' : '' ?>>
                <?= $this->Form->button(__('Filtrar'), ['class' => 'btn btn-success']) ?>
                <a id="empty" class="btn btn-default"><?= __('Limpar') ?></a>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Lista de turmas</h3>
                <?php if($loggedUser !== false && $loggedUser->canAdmin()): ?>
                <div class="pull-right box-tools">
                    <?= $this->Html->link(
                        '<i class="fa fa-plus-circle"></i> ' . __('Adicionar'),
                        ['action' => 'add'],
                        [
                            'escape' => false,
                            'data-toggle' => 'tooltip',
                            'data-original-title' => __('Adicionar'),
                            'class' => 'btn btn-sm btn-primary'
                        ]
                    );
                    ?>
                </div>
                <?php endif; ?>
            </div>
            <div class="box-body table-responsive no-padding">
                <table class="table table-striped table-valign-middle">
                    <thead>
                    <tr>
                        <th><?= $this->Paginator->sort('id', __('#ID')) ?></th>
                        <th><?= $this->Paginator->sort('process_id', __('Processo de distribuição')) ?></th>
                        <th><?= $this->Paginator->sort('name', __('Nome')) ?></th>
                        <th><?= $this->Paginator->sort('vacancies', __('N° de vagas')) ?></th>
                        <th><?= $this->Paginator->sort('subject_id', __('Disciplina')) ?></th>
                        <th><?= __('Status') ?></th>
                        <th><?= __('Docente(s) alocado(s)') ?></th>
                        <th width="<?= ($loggedUser !== false && $loggedUser->canAdmin()) ? '150px' : '75px' ?>"><?= __('Ações') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if($clazzes->isEmpty()): ?>
                        <tr>
                            <td colspan="7" class="text-center">Nenhuma turma encontrada</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($clazzes as $clazz): ?>
                            <tr>
                                <td><?= $this->Number->format($clazz->id) ?></td>
                                <td><?= $this->Html->link($clazz->process->name, ['controller' => 'Processes', 'action' => 'view', $clazz->process->id]) ?></td>
                                <td><?= h($clazz->name) ?></td>
                                <td><?= h($clazz->vacancies) ?></td>
                                <td><?= ($loggedUser !== false && $loggedUser->canAdmin()) ? $this->Html->link($clazz->subject->name, ['controller' => 'Subjects', 'action' => 'view', $clazz->subject->id]) : $clazz->subject->name ?></td>
                                <td><?= $clazz->displayStatus ?></td>
                                <td><?= $clazz->selectedTeachersNames ?></td>
                                <td>
                                    <?= $this->Html->link(
                                        '',
                                        ['action' => 'view', $clazz->id],
                                        [
                                            'title' => __('Visualizar'),
                                            'class' => 'btn btn-sm btn-default glyphicon glyphicon-search',
                                            'data-toggle' => 'tooltip',
                                            'data-original-title' => __('Visualizar'),
                                        ]
                                    ) ?>

                                    <?php if($loggedUser !== false && $loggedUser->canAdmin()): ?>
                                    <?= $this->Html->link(
                                        '',
                                        ['action' => 'edit', $clazz->id],
                                        [
                                            'title' => __('Editar'),
                                            'class' => 'btn btn-sm btn-primary glyphicon glyphicon-pencil',
                                            'data-toggle' => 'tooltip',
                                            'data-original-title' => __('Editar'),
                                        ]
                                    ) ?>
                                    <?= $this->Form->postLink(
                                        '',
                                        ['action' => 'delete', $clazz->id],
                                        [
                                            'confirm' => __('Você tem certeza de que deseja remover a turma "{0}/{1}"?', $clazz->name, $clazz->process->name),
                                            'title' => __('Remover'),
                                            'class' => 'btn btn-sm btn-danger glyphicon glyphicon-trash',
                                            'data-toggle' => 'tooltip',
                                            'data-original-title' => __('Remover'),
                                        ]
                                    ) ?>
									<?= $this->Html->link(
                                        '',
                                        ['action' => 'finalizarTurma', $clazz->id],
                                        [
                                            'title' => __('Finalizar Turma'),
                                            'class' => 'btn btn-sm btn-default glyphicon glyphicon-check',
                                            'data-toggle' => 'tooltip',
                                            'data-original-title' => __('Finalizar Turma'),
                                        ]
                                    ) ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="box-footer clearfix">
                <ul class="pagination pagination-sm no-margin pull-right">
                    <?= $this->Paginator->prev('«') ?>
                    <?= $this->Paginator->numbers() ?>
                    <?= $this->Paginator->next('»') ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    <?php $this->Html->scriptStart(['block' => true]); ?>
        $(document).ready(function() {
            $(".select2").select2({
                width: '100%'
            });

            $("#empty").click(function() {
                var form = $(this).closest('form');
                form.find("input[type=text], textarea").val("");

                form.find("select").each(function(elem) {
                    if($(this).prop('multiple') == true) {
                        $(this).find("option:selected").prop("selected", false);
                        $(this).select2('val', '');
                    } else {
                        $(this).find('option').first().prop('selected', true);
                    }
                });
            });
        });
    <?php $this->Html->scriptEnd(); ?>
</script>
