class CreateComments < ActiveRecord::Migration
  def change
    create_table :comments do |t|
      t.string :student_name
      t.string :text_area
      t.integer :student_id

      t.timestamps null: false
    end
  end
end
