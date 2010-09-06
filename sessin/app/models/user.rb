class User < ActiveRecord::Base
	validates_length_of :password, :within => 5..40
	validates_presence_of :email
	validates_uniqueness_of :email
	validates_format_of :email,
	
		:with => /^([^@\s]+)@((?:[-a-z0-9]+\.)+[a-z]{2,})$/i,
				:message => "Invalid email"
				
	attr_accessor :password
	
	attr_protected :password_salt
	
	def password= (pass)
		@password=pass
		self.password_salt = User.random_string(10) if !self.password_salt?
		self.password_hash = User.hash_password(@password, self.password_salt)
	end
	
	protected
	
	def self.hash_password(pass, password_salt)
		Digest::SHA1.hexdigest(pass+password_salt)
	end
	
	def self.random_string(len)
		chars = ("a".."z").to_a + ("A".."Z").to_a + ("0".."9").to_a
		newpass = ""
		1.upto(len) {|i| newpass << chars[rand(chars.size-1)]}
		return newpass
	end
	
	def self.authenticate(email, pass)
		u=find(:first, :conditions=>["email = ?", email])
		return nil if u.nil?
		if User.hash_password(pass, u.password_salt)==u.password_hash
			if (u.login_count == nil)
				u.login_count = 0
			end
			u.update_attributes(:login_count => u.login_count+1, :last_login => DateTime.now)
			u.save_without_validation()
			return u
		end
		nil
	end
end
