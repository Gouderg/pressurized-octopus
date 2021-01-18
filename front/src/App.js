import {
	Link,
	Route,
	BrowserRouter as Router,
	Switch
  } from "react-router-dom";

import './stylesheets/App.css';
import logo from './img/logo.png';
import {HomePage, TableShow, CalculForm, CalculResult} from './Components';

function App() {

	return (
		<Router>
			<div className="App">
				<header className="App-header">
					<div className="App-logo-title">
						<img src={logo} className="App-logo" alt="logo" />
						<h1 className="App-header-title"><Link className="link" to="/">Pressurized Octopus</Link></h1>
					</div>
					
					<nav>
						<div className="App-header-link" > 
							<h2><Link className="link" to="/table">Table</Link></h2>
							<h2><Link className="link" to="/calculform">Calcul</Link></h2>
						</div>
					</nav>
				</header>
				<div className="Container">
					<Switch>
						<Route exact path="/"><HomePage /></Route>
						<Route path="/table"><TableShow /></Route>
						<Route path="/calculform"><CalculForm /></Route>
						<Route path="/calculresult"><CalculResult /></Route>
					</Switch>
				</div>
				<footer className="App-footer">
					{/* <span className="App-footer-citation">© Copyright 2021 | PRALAIN Léopold - ILLIEN Victor</span> */}
				</footer>
			</div>
		</Router>
  	);
}

export default App;
