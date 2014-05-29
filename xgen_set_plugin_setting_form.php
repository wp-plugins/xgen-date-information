<div class="width_100">
	<h2>xGen Plugin Date Information</h2>
	<?php
		if(isset($message)){
			$message_output = htmlspecialchars(strip_tags(esc_sql($message)));
			echo "<div style='color:green;font-size:14px;'>".$message_output."</div>";
		}
	?>
	<form action='?page=xgen_plugin_date_information' method='POST'>
		<h3>Select the column which you want to see on plugin page</h3>
		<div class="width_100">
			<div class="width_20 fl">Show Install Date Column:</div>
			<div class="width_80 fl">
				<?php
					$yes=$no='';
					$install_date_value	= get_option('install_date_value');
					if($install_date_value=='yes'){
						$yes   = "selected='selected'";
						$no    = "";
					}elseif($install_date_value=='no'){
						$yes   = "";
						$no    = "selected='selected'";
					}
				?>
				<select id='install_date_value' name='install_date_value' class="custom_select_tag">
					<option value='yes' <?=$yes?>>Yes</option>
					<option value='no' <?=$no?>>No</option>
				</select>
			</div>
			
			<div class="width_20 fl">Show Activated Date Column:</div>
			<div class="width_80 fl">
	    		<?php
					$yes=$no='';
					$activated_date_value	= get_option('activated_date_value');
					if($activated_date_value=='yes'){
						$yes   = "selected='selected'";
						$no    = "";
					}elseif($activated_date_value=='no'){
						$yes   = "";
						$no    = "selected='selected'";
					}
				?>
				<select id='activated_date_value' name='activated_date_value' class="custom_select_tag">
					<option value='yes' <?=$yes?>>Yes</option>
					<option value='no' <?=$no?>>No</option>
				</select>
			</div>
			
			<div class="width_20 fl">Show Deactivated Date Column:</div>
			<div class="width_80 fl">
	    		<?php
					$yes=$no='';
					$deactivated_date_value	= get_option('deactivated_date_value');
					if($deactivated_date_value=='yes'){
						$yes   = "selected='selected'";
						$no    = "";
					}elseif($deactivated_date_value=='no'){
						$yes   = "";
						$no    = "selected='selected'";
					}
				?>
				<select id='deactivated_date_value' name='deactivated_date_value' class="custom_select_tag">
					<option value='yes' <?=$yes?>>Yes</option>
					<option value='no' <?=$no?>>No</option>
				</select>	
			</div>

			<div class="width_20 fl">Show Plugin Last Updated Information In Description Column:</div>
			<div class="width_80 fl">
	    		<?php
					$yes=$no='';
					$updated_date_value	= get_option('updated_date_value');
					if($updated_date_value=='yes'){
						$yes   = "selected='selected'";
						$no    = "";
					}elseif($updated_date_value=='no'){
						$yes   = "";
						$no    = "selected='selected'";
					}
				?>
				<select id='updated_date_value' name='updated_date_value' class="custom_select_tag">
					<option value='yes' <?=$yes?>>Yes</option>
					<option value='no' <?=$no?>>No</option>
				</select>	
			</div>
		</div>
		<div>&nbsp;</div>
		<div class="width_100" style="border-top:2px solid lightgrey;">
			<h3>Enter the expected column name and width for the same.</h3>
			<div class="width_20 fl">Install Date Column Text</div>
			<div class="width_80 fl">
				<input type='text' value="<?php echo get_option('install_column_text'); ?>" id='install_column_text' name='install_column_text' class="custom_textbox"/>
			</div>

			<div class="width_20 fl">Activated Date Column Text</div>
			<div class="width_80 fl">
				<input type='text' value="<?=get_option('activated_column_text');?>" id='activated_column_text' name='activated_column_text' class="custom_textbox" />
			</div>

			<div class="width_20 fl">Deactivated Date Column Text</div>
			<div class="width_80 fl">
				<input type='text' value="<?=get_option('deactivated_column_text');?>" id='deactivated_column_text' name='deactivated_column_text' class="custom_textbox" />
			</div>

			<div class="width_20 fl">Last Updated Plugin Date Column Text</div>
			<div class="width_80 fl">
				<input type='text' value="<?=get_option('update_column_text');?>" id='update_column_text' name='update_column_text' class="custom_textbox" />
			</div>
		</div>
		<div>&nbsp;</div>
		<div>
			<input type="submit" value="Save Setting" name="xgen_pdi_submit" id="xgen_pdi_submit" class="button-primary"/>
		</div>
	</form>
</div>