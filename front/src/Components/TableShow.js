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

                <div className="table">
                    <div className="table-result">
                        <div className="table-result-header">
                            <div className="table-result-th">Profondeur</div>
                            <div className="table-result-th">Temps</div>
                            <div className="table-result-th">Palier 15</div>
                            <div className="table-result-th">Palier 12</div>
                            <div className="table-result-th">Palier 9</div>
                            <div className="table-result-th">Palier 6</div>
                            <div className="table-result-th">Palier 3</div>
                        </div>
                        <div className="table-result-content">
                            {result && Object.keys(result).map((profondeur) => {
                                return (
                                    result[profondeur].map((elt) => (
                                        <div className="table-result-row">
                                            <div className="table-result-data profondeur">{profondeur}</div>
                                            <div className="table-result-data">{elt.temps}</div>
                                            <div className="table-result-data">{elt.palier15}</div>
                                            <div className="table-result-data">{elt.palier12}</div>
                                            <div className="table-result-data">{elt.palier9}</div>
                                            <div className="table-result-data">{elt.palier6}</div>
                                            <div className="table-result-data">{elt.palier3}</div>
                                        </div>
                                    ))
                                );
                            })}
                        </div>
                    </div>
                </div>
			</div>
	);
};

export default TableShow;