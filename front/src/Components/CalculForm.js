import React from "react";

import '../stylesheets/CalculForm.css';



const CalculForm = () => {
	const [data, setData] = React.useState();
	const [result, setResult] = React.useState({});

	const handleChange = (e) => 
	{
		setData(
			{
				...data,
				[e.target.name]: e.target.value.trim()
			}
		)

	}

	const handleSubmit = (e) =>
	{
		e.preventDefault()
		
		var requestOptions = {
  		method: 'GET',
  		redirect: 'follow'
	};

		fetch("http://127.0.0.1:8000/api/resultForm?profondeur="+data.profondeur+"&bouteille="+data.bouteille+"&litre="+data.litre+"&temps="+data.temps, requestOptions)
		  .then(response => response.json())
		  .then(result => setResult(result))
		  .catch(error => console.log('error', error));
	}
	React.useEffect(()=>{
		console.log(data)
	},[data])

   

    return (
        <div id="sku">
            <h1> Formulaire de saisie </h1>
            <br/>
            <br/>
            <form onSubmit={handleSubmit} >
            Contenance de la bouteille :
            <select name="litre" id= "litre" onChange={handleChange}>
            	<option value="9"> 9L</option>
            	<option value="12"> 12L</option>
            	<option value="15"> 15L</option>
            	<option value="18"> 18L</option>
            </select>
            <br/>
            <br/>
            Remplissage de la bouteille
             <input type="number" id="bouteille" name="bouteille" min="0"  defaultValue="200" max= "250" onChange={handleChange}></input>
             <br/>
             <br/>
             Durée de la ploongée avant la remonter en min :
             <input type="number" min="0" max="200" name="temps" onChange={handleChange}></input>
             <br/>
             <br/>
             Profondeur Max:
             <input type="number" min="0" max="70" name="profondeur" onChange={handleChange}></input>
             <br/>
             <br/>
             <button type="submit">Submit</button>

            </form>

            <div>
            {JSON.stringify(result)}
            </div>

        </div>
    );
};

export default CalculForm;