import React from "react";

import '../stylesheets/CalculForm.css';



const CalculForm = () => {

	const [data, setData] = React.useState();
    const [result, setResult] = React.useState(false);

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

		fetch("http://127.0.0.1:8000/api/calc?tableplonge="+data.tableplonge+"&profondeur="+data.profondeur+"&pressionbout="+data.bouteille+"&volumebout="+data.litre+"&temps="+data.temps, requestOptions)
		  .then(response => response.json())
		  .then(result => setResult(result))
          .catch(error => console.log('error', error));
        
	}
	React.useEffect(()=>{
		console.log(data)
	},[data])

   

    return (
        <div id="centre">
    <h1 id="title"> Formulaire de saisie </h1>
    <br/>
    <br/>
        <div id="gauche">
        <div id="decalage">
            <form onSubmit={handleSubmit} >
                <div>
                    <h2>Choix de la Table : </h2>
                    <label>
                        <h4>BULLMAN</h4>
                    </label>
                    <input type="radio" value="1" name="tableplonge" onChange={handleChange} />
                    <label>
                        <h4>MN90</h4>
                    </label>
                    <input type="radio" value="2" name="tableplonge" onChange={handleChange} />
                </div>
                <h2>Contenance de la bouteille : </h2>
                <select name="litre" id= "litre" onChange={handleChange}>
                    <option value="9"> 9L</option>
                    <option value="12"> 12L</option>
                    <option value="15"> 15L</option>
                    <option value="18"> 18L</option>
                </select>
                <h2>Remplissage de la bouteille : </h2>
                <input type="number" id="bouteille" name="bouteille" min="0"  defaultValue="200" max= "250" onChange={handleChange}></input>
                <h2>Durée de la ploongée avant la remonter en min : </h2>
                <input type="number" min="0" max="200" name="temps" defaultValue="10" onChange={handleChange}></input>
                <h2>Profondeur Max : </h2>
                <input type="number" min="0" max="70" name="profondeur" defaultValue="10" onChange={handleChange}></input>
                <br/>
                <br/>
                <button type="submit" id="gros_boutton">Submit</button>
            </form>
            </div>
        </div>
        <div className="vl"></div>
        <div id="droite">
            <h1 className="graphe"> Résultats </h1>
            <div >
                {result &&
                <div className="result"> 
                <div className="dep">
                    <h2>Durée de la remontée: {result.dtr} min </h2>
                    <h2>Durée totale de la plongée: {result.dtp} min</h2>
                    <h2>Avant remontée: {result.vbAvantRemonte} L à {result.pbAvantRemonte} bar</h2>
                    <h2>Après remontée: {result.vbApresRemonte} L à {result.pbApresRemonte} bar</h2>
                    <h2>Profondeur de la plongée: {result.profondeur} mètres</h2>
                   
                    </div>
                </div>
                }
            </div>
        </div>

</div>
    );
};

export default CalculForm;