When changing an exported variable's value from a script in Tool mode, the value in the inspector won't be updated automatically. 

To update it, call `notify_property_list_changed()` after setting the exported variable's value.