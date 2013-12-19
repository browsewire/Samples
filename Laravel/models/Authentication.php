<?php

class Authentication extends Eloquent {
	
		protected $table = 'authentications';
		protected $fillable = array(
								'user_id',
								'provider',
								'email',
								'display_name',
								'first_name',
								'last_name',
								'profile_url',
								'website_url'
								);
	
	}
