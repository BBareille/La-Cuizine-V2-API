<h1>HOW API WORK</h1>

<ul>
<li>
'GET' on /api/ingredients

return json list of ingredients in database
</li>
<li>
'POST' on /api/newIngredient/{name}

{name} = name of the new ingredient you want to add
return json of the newIngredient
</li>
<li>
'DELETE' on /api/deleteIngredient/{id}

{id} = id of the ingredient you want to delete
return json of the deleted ingredient
</li>
<li>
'PUT' on /api/updateIngredient/{id}/{newName}

{id} = id of the ingredient you want to modify
{newName} = the name you want on this ingredient
return json of this ingredient
</li>
<ul>
