<div clss="wrap">
	<h1><?php esc_html_e('Calendar','wedesigntech-ultimate-booking-addon');?></h1>
	<h2><?php esc_html_e('Reservation System','wedesigntech-ultimate-booking-addon');?></h2>

	<div id="dt-calendar-wrapper"><?php
		$cp_members = get_posts( array('post_type'=>'dt_staff','posts_per_page'=>'-1', 'orderby'=>'title', 'order'=>'asc' ) );
		if( $cp_members ){ ?>
			<ul id="dt-members-list"><?php
				foreach( $cp_members as $i => $cp_member ) {
					$id = $cp_member->ID; 
					$name = $cp_member->post_title;
					$class = ( $i == 0 ) ? 'active' : '';?>
					<li><a href="#" data-memberid="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $class ); ?>"><?php echo "{$name}";?></a></li><?php
				}?>
			</ul><?php
		}?>

		<!-- Calendar -->
		<div class="dt-calendar">
		</div><!-- Calendar End -->

		<!-- Event Add Form -->
		<div id="event_edit_container">
			<form>
				<input type="hidden" name="member_id" />
				<ul>
					<li>
						<span><?php esc_html_e('Date','wedesigntech-ultimate-booking-addon');?></span>
						<span class="date_holder"></span>
					</li>

					<li>
						<label for="start"><?php esc_html_e('Start Time','wedesigntech-ultimate-booking-addon');?></label>
						<select name="start">
							<option value=""><?php esc_html_e('Select Start Time','wedesigntech-ultimate-booking-addon');?></option>
						</select>
					</li>

					<li>
						<label for="end"><?php esc_html_e('End Time','wedesigntech-ultimate-booking-addon');?></label>
						<select name="end">
							<option value=""><?php esc_html_e('Select End Time','wedesigntech-ultimate-booking-addon');?></option>
						</select>
					</li>

					<li>
						<label for="services"><?php esc_html_e('Service','wedesigntech-ultimate-booking-addon');?></label>
						<select name="service"></select>
					</li>

					<li>
						<label for="customer"><?php esc_html_e('Customer','wedesigntech-ultimate-booking-addon');?></label>
						<select name="customer">
							<option value=""><?php esc_html_e('Select','wedesigntech-ultimate-booking-addon');?></option><?php
							$cp_customers = get_posts( array('post_type'=>'dt_customers','posts_per_page'=>'-1', 'orderby'=>'title', 'order'=>'asc' ) );
							if( $cp_customers ){
								foreach( $cp_customers as $i => $cp_customer ){
									$id = $cp_customer->ID; 
									$name = $cp_customer->post_title;
									echo "<option value='{$id}'>{$name}</option>";
								}
							}?></select>
					</li>

					<li>
						<label for="title"><?php esc_html_e('Title','wedesigntech-ultimate-booking-addon');?></label>
						<input type="text" name="title" />
					</li>

					<li>
						<label for="body"><?php esc_html_e('Body','wedesigntech-ultimate-booking-addon');?></label>
						<textarea name="body"></textarea>
					</li>
				</ul>
			</form>
		</div><!-- Event Add Form End -->
	</div>
</div>