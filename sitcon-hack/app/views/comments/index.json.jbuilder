json.array!(@comments) do |comment|
  json.extract! comment, :id, :student_name, :text_area, :student_id
  json.url comment_url(comment, format: :json)
end
