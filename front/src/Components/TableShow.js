import React from "react";
import './global.js';
import '../stylesheets/TableShow.css';


const TableShow = () => {
	const [tables, setTables] = React.useState({id: "1"});
	const [result, setResult] = React.useState();

	const handleChange = (e) => {
		setTables({
			...tables, [e.target.name]: e.target.value.trim()
		})
	}

	React.useEffect(() => {
		console.log(tables)
	}, [tables])

	React.useEffect(() => {
		fetch(global.path+"/api/tables/show/"+tables.id)      
			.then((response) =>response.json())      
			.then((result) =>setResult(result))
			.catch(error => console.log('error', error));		  
	}, [tables]);

		return(
			<div>
                <div className="choices">
                    <h2>Choix de la Table : </h2>
                    <div className="radio">
                        <label><h4>BULLMAN:</h4></label> <input type="radio" value="1" name="id" onChange={handleChange} required/>
                        <label><h4>MN90:</h4></label> <input type="radio" value="2" name="id" onChange={handleChange} required/>
                    </div>
                </div>

                <div>
                <table>
                    <thead>
                        <tr>
                            <th>Profondeur</th>
                            <th>Temps</th>
                            <th>Palier 15</th>
                            <th>Palier 12</th>
                            <th>Palier 9</th>
                            <th>Palier 6</th>
                            <th>Palier 3</th>
                        </tr>
                    </thead>
                    <tbody>
                    {result && Object.keys(result).map((profondeur) => {
                        return (
                            result[profondeur].map((elt) => (
                                <tr>
                                    <td>{profondeur}</td>
                                    <td>{elt.temps}</td>
                                    <td>{elt.palier15}</td>
                                    <td>{elt.palier12}</td>
                                    <td>{elt.palier9}</td>
                                    <td>{elt.palier6}</td>
                                    <td>{elt.palier3}</td>
                                </tr>
                            ))
                        );
                    })}
                    </tbody>
                </table>
                </div>
			</div>
	);
};

export default TableShow;