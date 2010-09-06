# Filters added to this controller apply to all controllers in the application.
# Likewise, all the methods added will be available for all controllers.

class ApplicationController < ActionController::Base
    helper :all # include all helpers, all the time

    # See ActionController::RequestForgeryProtection for details
    # Uncomment the :secret if you're not using the cookie session store
    protect_from_forgery # :secret => '413a21bb90de98d36d5c6f050993df3a'

    # See ActionController::Base for details 
    # Uncomment this to filter the contents of submitted sensitive data parameters
    # from your application log (in this case, all fields with names like "password"). 
    # filter_parameter_logging :password

    def login_required
    if session[:user]
        return true
    end
    flash[:notice] = "Please login to continue"
    session[:return_to] = request.request_uri
    redirect_to :controller => "user", :action => "signup"
    return false
    end
end
