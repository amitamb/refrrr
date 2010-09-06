class WebSessionController < ApplicationController

	before_filter :login_required

	def index
		current_user = User.find(session[:user])
		@web_sessions = current_user.web_sessions
	end
	
	def new
		if request.post?
			
		else
			@web_session = WebSession.new
		end
	end
end
