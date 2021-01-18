import React from "react";
import './global.js'
import '../stylesheets/CalculForm.css';



const CalculForm = () => {

	const [data, setData] = React.useState({tableplonge: "1", litre: "15", bouteille: "200", temps:"15", profondeur:"48"});
    const [result, setResult] = React.useState();

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
        console.log("hello")
		e.preventDefault()
		
		var requestOptions = {
  		    method: 'GET',
  		    redirect: 'follow'
	    };

		fetch(global.path+"/api/calc?tableplonge="+data.tableplonge+"&profondeur="+data.profondeur+"&pressionbout="+data.bouteille+"&volumebout="+data.litre+"&temps="+data.temps, requestOptions)
		  .then(response => response.json())
		  .then(result => setResult(result))
          .catch(error => console.log('error', error));
        
        console.log(result)
	}
	React.useEffect(()=>{
		console.log(data)
	},[data])

   

    return (
        <div id="centre">
            <h1 id="title"> Formulaire de saisie </h1>
            <br/><br/>
            <div id="gauche">
                <div id="decalage">
                    <form onSubmit={handleSubmit} >
                        
                        <h2>Choix de la Table : </h2>
                        <div className="form-radio">
                            <label><h4>BULLMAN:</h4></label> <input type="radio" value="1" name="tableplonge" onChange={handleChange} required/>
                            <label><h4>MN90:</h4></label> <input type="radio" value="2" name="tableplonge" onChange={handleChange} required/>
                        </div>
                        
                        <h2>Contenance de la bouteille : </h2>
                        <select name="litre" id= "litre" onChange={handleChange} required>
                            <option value="9"> 9L</option>
                            <option value="12"> 12L</option>
                            <option value="15" selected> 15L</option>
                            <option value="18"> 18L</option>
                        </select>
                        
                        <h2>Remplissage de la bouteille : </h2>
                        <input type="number" size="1" id="bouteille" name="bouteille" min="0"  defaultValue={data.bouteille} max= "250" onChange={handleChange} required />
                
                        <h2>Durée de la plongée avant la remontée en min : </h2>
                        <input type="number" size="1" min="0" max="200" name="temps" defaultValue={data.temps} onChange={handleChange} required />
                        
                        <h2>Profondeur Max : </h2>
                        <input type="number" size="1" min="0" max="70" name="profondeur" defaultValue={data.profondeur} onChange={handleChange} required />
                        
                        <br/><br/>
                        <button type="submit" id="gros_boutton">Submit</button>
                    </form>
                </div>
            </div>
            <div className="vl"></div>
            <div id="droite">
                <h1 className="graphe"> Résultats </h1>
                <div>
                    {result &&
                        <div className="result"> 
                            <div className="dep">
                                <h2>Durée de la remontée: {result.dtr} min </h2>
                                <h2>Durée totale de la plongée: {result.dtp} min</h2>
                                <h2>Avant remontée: {result.vbAvantRemonte} L à {result.pbAvantRemonte} bar</h2>
                                <h2>Après remontée: {result.vbApresRemonte} L à {result.pbApresRemonte} bar</h2>
                                <h2>Profondeur de la plongée: {result.profondeur} mètres</h2>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Temps</th>
                                            <th>Palier 15</th>
                                            <th>Palier 12</th>
                                            <th>Palier 9</th>
                                            <th>Palier 6</th>
                                            <th>Palier 3</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{result.palier.temps}</td>
                                            <td>{result.palier.palier15}</td>
                                            <td>{result.palier.palier12}</td>
                                            <td>{result.palier.palier9}</td>
                                            <td>{result.palier.palier6}</td>
                                            <td>{result.palier.palier3}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    }
                </div>
            </div>
        </div>
    );
};

export default CalculForm;