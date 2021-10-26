<?php

if (isset($form)) { ?>
<style>
    .site-title,
    .site-description,
    .post,
    .entry-title {
        display: none;
    }
</style>
    <div>
        <div class="bg-white shadow-lg p-4 w-full m-auto">
            <div class="border p-4 rounded">
                <h1 class="text-center">
                    <?php echo $form->title; ?> <span class="border border-gray-300 px-2 py-1 rounded bg-gray-100"><?php echo $form->shortcode; ?></span>
                </h1>
                <form id="<?php echo $form->form_id; ?>" class="<?php echo $form->classes; ?>">
                    <input type="hidden" name="id" value="<?php echo $form->id; ?>">
                    <?php
                    if (isset($form->fields) && count($form->fields) > 0) {
                        foreach ($form->fields as $key => $field) { ?>
                            <div class="w-full my-4">
                                <label class="block" for="<?php echo $field->field_id; ?>">
                                    <?php echo $field->label; ?>
                                    <?php
                                    if ($field->is_required == 1) { ?>
                                        <span class="text-red-600 font-bold">*</span>
                                    <?php }
                                    ?>
                                </label>

                                <?php
                                if (
                                    $field->type == 'input' &&
                                    $field->input_type != 'checkbox' &&
                                    $field->input_type != 'radio'
                                ) { ?>
                                    <input type="<?php echo $field->input_type; ?>" <?php echo $field->is_required == 1 ? 'required' : ''; ?> class="w-full" name="<?php echo $field->name; ?>" id="<?php echo $field->field_id; ?>" placeholder="<?php echo $field->placeholder; ?>" style="width: <?php echo $field->width; ?>; height: <?php echo $field->height; ?>" />
                                <?php }
                                ?>

                                <?php if ($field->type == 'textarea') { ?>
                                    <textarea rows="<?php echo $field->rows; ?>" <?php echo $field->is_required == 1 ? 'required' : ''; ?> class="w-full border border-gray-400 rounded" name="<?php echo $field->name; ?>" id="<?php echo $field->field_id; ?>" placeholder="<?php echo $field->placeholder; ?>" style="width: <?php echo $field->width; ?>; height: <?php echo $field->height; ?>"></textarea>
                                <?php } ?>


                                <?php if ($field->type == 'input' && $field->input_type == 'radio') { ?>
                                    <div>
                                        <?php
                                        if (isset($field->options) && count($field->options) > 0) {
                                            foreach ($field->options as $key => $option) { ?>
                                                <label for="<?php echo $field->form_id; ?>">
                                                    <input type="<?php echo $field->input_type; ?>" name="<?php echo $field->name; ?>" id="<?php echo $field->form_id; ?>" value="<?php echo $option->value; ?>" />
                                                    <?php echo $option->text; ?>
                                                </label>
                                        <?php }
                                        } ?>
                                    </div>
                                <?php } ?>

                                <?php if ($field->type == 'input' && $field->input_type == 'checkbox') { ?>
                                    <div>
                                        <?php
                                        if (isset($field->options) && count($field->options) > 0) {
                                            foreach ($field->options as $key => $option) { ?>
                                                <label for="<?php echo $field->form_id; ?>">
                                                    <input type="<?php echo $field->input_type; ?>" name="<?php echo $field->name; ?>" id="<?php echo $field->form_id; ?>" value="<?php echo $option->value; ?>" />
                                                    <?php echo $option->text; ?>
                                                </label>
                                        <?php }
                                        } ?>
                                    </div>
                                <?php } ?>

                                <?php if ($field->type == 'select') { ?>
                                    <select class="w-full min-w-full" <?php echo $field->is_required == 1 ? 'required' : ''; ?> name="<?php echo $field->name; ?>[]" id="<?php echo $field->field_id; ?>" style="width: <?php echo $field->width; ?>;height: <?php echo $field->height; ?>">
                                        <option value="">Select ...</option>
                                        <?php
                                        if (isset($field->options) && count($field->options) > 0) {
                                            foreach ($field->options as $key => $option) { ?>
                                                <option value="<?php echo $option->value; ?>"><?php echo $option->text; ?></option>
                                        <?php }
                                        } ?>
                                    </select>
                                <?php } ?>
                            </div>
                        <?php }
                        ?>
                        <div class="w-full mt-4">
                            <button type="submit" class="px-4 py-2 bg-green-500 text-white font-bold rounded-md hover:text-white hover:bg-green-600 transition-all delay-300 ease-in-out">
                                Submit
                            </button>
                        </div>
                </form>

            <?php } else { ?>
            <?php } ?>
            </div>
        </div>
    </div>

    <script>
        jQuery(document).ready(function($) {
            $("#<?php echo $form->form_id; ?>").submit(function(e) {
                e.preventDefault();
                const data = $(this).serialize();
                $.ajax({
                    type: "POST",
                    url: '/wp-json/dynamic-form/v1/entries',
                    data: data,
                    dataType: 'JSON',
                    success: function(response) {
                        window.location.reload()
                    }
                });
            });

        });
    </script>
<?php } else { ?>

<?php } ?>