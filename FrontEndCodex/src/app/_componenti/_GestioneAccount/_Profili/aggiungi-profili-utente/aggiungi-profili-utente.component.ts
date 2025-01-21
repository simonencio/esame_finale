import { Component, OnDestroy, OnInit } from '@angular/core';
import { map, Observable, Subject, takeUntil, tap } from 'rxjs';
import { IRispostaServer } from 'src/app/_interfacce/IRispostaServer.interface';
import { ApiService } from 'src/app/_servizi/api.service';
import { Profilo } from 'src/app/_type/_Admin/profilo.type'; // Importing Profilo type

@Component({
  selector: 'app-aggiungi-profili-utente', // Updated selector
  templateUrl: './aggiungi-profili-utente.component.html', // Updated template URL
  styleUrls: ['./aggiungi-profili-utente.component.scss'] // Updated style URL
})
export class AggiungiProfiliComponent implements OnInit, OnDestroy {
  elencoProfili$: Observable<IRispostaServer>;
  dati: Profilo[] = []; // Changed from TipologieIndirizzi[] to Profilo[]
  private distruggi$ = new Subject<void>();

  // New properties for form inputs
  newIdProfilo: number | null = null; // New property for Profilo ID
  newIdContatto: number | null = null; // New property for Contatto ID
  newNome: string = ''; // Property for the name of the Profilo
  isFormVisible: boolean = true; // Property to control form visibility
  loggedInIdContatto: number | null = null; // Store the logged-in user's idContatto

  constructor(private api: ApiService) {
    this.elencoProfili$ = this.api.getProfilo().pipe( // Changed to getProfili
      takeUntil(this.distruggi$),
      tap(response => {
        this.dati = response.data; // Assuming response has a data property
      })
    );
  }

  ngOnInit(): void {
    // Retrieve the logged-in user's idContatto from session storage
    this.loggedInIdContatto = this.getLoggedInIdContatto();
    this.newIdContatto = this.loggedInIdContatto; // Set the idContatto in the form

    // Subscribe to elencoProfili$ if not using async pipe in the template
    this.elencoProfili$.subscribe({
      error: (err) => console.error('Error fetching profiles:', err) // Updated error message
    });
  }

  ngOnDestroy(): void {
    // Unsubscribe from all observables
    this.distruggi$.next();
    this.distruggi$.complete(); // Complete the subject to free resources
  }

  // Add a new profile
  aggiungiValore() {
    console.log("AGGIUNGI VALORE");

    // Create the parameter object using the form values
    const parametro: Partial<Profilo> = {
      idProfilo: this.newIdProfilo !== null ? this.newIdProfilo : undefined, // Assign undefined if null
      idContatto: this.newIdContatto !== null ? this.newIdContatto : undefined, // Assign undefined if null
      nome: this.newNome,
    };

    // Call the observable to add the new profile
    this.obsAddProfilo(parametro).subscribe({
      next: (response) => {
        console.log('Profilo aggiunto:', response);
        this.dati.push(response); // Assuming response contains the added profile
        this.resetForm(); // Reset the form fields after adding
        location.reload(); // Reload the page to refresh the profiles list
      },
      error: (err) => console.error('Error adding profile:', err)
    });
  }

  // Observable for adding a new profile
  obsAddProfilo(dati: Partial<Profilo>) {
    return this.api.postProfilo(dati).pipe( // Changed to postProfili
      takeUntil(this.distruggi$),
      tap(x => console.log("OBS ", x)),
      map(x => x.data) // Assuming the response structure contains a `data` property
    );
  }

  // Method to reset the form fields
  resetForm() {
    this.newIdProfilo = null; // Resetting the newIdProfilo
    this.newIdContatto = this.loggedInIdContatto;
    this.newNome = ''; // Resetting the newNome
  }

  // Method to retrieve the logged-in user's idContatto from session storage
  private getLoggedInIdContatto(): number | null {
    const authData = sessionStorage.getItem('auth'); // Assuming the auth data is stored under the key 'auth'
    if (authData) {
      const parsedData = JSON.parse(authData); // Parse the JSON string
      return parsedData.idContatto ? parseInt(parsedData.idContatto, 10) : null; // Convert to number
    }
    return null; // Return null if not found
  }
}