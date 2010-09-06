class CreateWebSessions < ActiveRecord::Migration
  def self.up
    create_table :web_sessions do |t|
        
        t.timestamps
    end
  end

  def self.down
    drop_table :web_sessions
  end
end
