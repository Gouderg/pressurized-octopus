import React from "react";
import './global.js' // sera le path utilisé ( 127.0.0.1:3000)
import '../stylesheets/CalculForm.css';//permet d'avoir accès au css



const CalculForm = () => {

	const [data, setData] = React.useState({tableplonge: "1", litre: "15", bouteille: "200", temps:"15", profondeur:"48"});//utilisation d'une variable d'état pour avoir de la donnéedès le début, cette var nous permettra aussi de transmettre de la donnée vers notre sevreur
    const [result, setResult] = React.useState();//variable d'état nous permettant d'avoir les resultats du serveur

	const handleChange = (e) => //hanfle change nous permet d'avoir des données à jour quand celle ci sont changés
	{
		setData(
			{
				...data, // split la var data
				[e.target.name]: e.target.value.trim() // permet d'actualiser les val de data en fonction de celle rentré 
			}
		)

	}

	const handleSubmit = (e) => //handle submit envoie les donné aux seveur quand on clique sur submit 
	{
        
		e.preventDefault() //ici on attends l'évenement 
		
		var requestOptions = { // on passe les paramètres en GET
  		    method: 'GET',
  		    redirect: 'follow'
	    };

		fetch(global.path+"/api/calc?tableplonge="+data.tableplonge+"&profondeur="+data.profondeur+"&pressionbout="+data.bouteille+"&volumebout="+data.litre+"&temps="+data.temps, requestOptions)
		  .then(response => response.json())
		  .then(result => setResult(result))
          .catch(error => console.log('error', error));//on fetch les param en GET et on retourne la reponse en JSON, si il ya une error on console log error 
        
        console.log(result)
	}
	React.useEffect(()=>{ //permet d'avoir les valeur à jour dans le console log 
		console.log(data)
	},[data])

   
    // parti ou on recolte les données et on les renvoies 
    return (

        <div>

          <h1 id="title"> Formulaire de saisie </h1>
          <h1 className="graphe"> Résultats </h1>
       
        <div id="centre">

            <br/><br/>
            <div id="gauche">
                
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
            <div className="vl"></div>
            <div id="droite">
                
                <div>
                    {result &&
                        <div className="result"> 
                            <div className="dep">
                                <h2>Durée de la remontée: <span className="result_color"> {result.dtr} min </span> </h2>
                                <h2>Durée totale de la plongée: <span className="result_color">{result.dtp} min </span> </h2>
                                <h2>Avant remontée: <span className="result_color">{result.vbAvantRemonte} L </span> à <span className="result_color">{result.pbAvantRemonte} bar</span></h2>
                                <h2>Après remontée: <span className="result_color">{result.vbApresRemonte} L</span>  à <span className="result_color">{result.pbApresRemonte} bar</span></h2>
                                <h2>Profondeur de la plongée: <span className="result_color">{result.profondeur} mètres </span></h2>
                                <table>
                                    <thead>
                                        <tr>
                                            <th><h2>Temps</h2></th>
                                            <th><h2>Palier 15</h2></th>
                                            <th><h2>Palier 12</h2></th>
                                            <th><h2>Palier 9</h2></th>
                                            <th><h2>Palier 6</h2></th>
                                            <th><h2>Palier 3</h2></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><h2>{result.palier.temps}</h2></td>
                                            <td><h2>{result.palier.palier15}</h2></td>
                                            <td><h2>{result.palier.palier12}</h2></td>
                                            <td><h2>{result.palier.palier9}</h2></td>
                                            <td><h2>{result.palier.palier6}</h2></td>
                                            <td><h2>{result.palier.palier3}</h2></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    }
                </div>
            </div>
        </div>
    </div>
    );
};

export default CalculForm;