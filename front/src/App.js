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
					<img src={logo} className="App-logo" alt="logo" />
					<nav>
						<ul className="App-ul"> 
							<li className="App-header-title"><Link to="/">Pressurized Octopus</Link></li>
							<li><Link to="/table">Table</Link></li>
							<li><Link to="/calculform">Calcul</Link></li>
						</ul>
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

				</footer>
			</div>
		</Router>
  	);
}

export default App;
