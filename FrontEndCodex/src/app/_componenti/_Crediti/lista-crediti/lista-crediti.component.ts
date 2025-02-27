import { Component, OnInit, Output, EventEmitter } from '@angular/core';
import { ApiService } from 'src/app/_servizi/api.service';
import { Observable, Subject, takeUntil, tap } from 'rxjs';
import { IRispostaServer } from 'src/app/_interfacce/IRispostaServer.interface';
import { Credito } from 'src/app/_type/_Admin/crediti.type'; // Ensure Credito includes idContatto
import { Contatto } from 'src/app/_type/_Admin/Contatto.type'; // Import Contatto type

@Component({
  selector: 'app-lista-crediti',
  templateUrl: './lista-crediti.component.html',
  styleUrls: ['./lista-crediti.component.scss']
})
export class ListaCreditoComponent implements OnInit {
  elencoCrediti$: Observable<IRispostaServer>;
  dati: Credito[] = [];
  private distruggi$ = new Subject<void>();
  contatti: Contatto[] = []; // Array to hold contatti data

  @Output() creditoSelected = new EventEmitter<{ action: string, credito: Credito }>();

  constructor(private api: ApiService) {
    this.elencoCrediti$ = this.api.getCredito().pipe(
      takeUntil(this.distruggi$),
      tap(response => {
        this.dati = response.data; // Assuming response has a data property
        // Sort the data by idContatto
        this.dati.sort((a, b) => a.idContatto - b.idContatto);
      })
    );
  }

  ngOnInit(): void {
    this.elencoCrediti$.subscribe({
      error: (err) => console.error('Error fetching credits:', err)
    });

    // Fetch contatti data
    this.api.getContatto().pipe(
      takeUntil(this.distruggi$),
      tap(response => {
        this.contatti = response.data; // Assuming response has a data property
      })
    ).subscribe({
      error: (err) => console.error('Error fetching contatti:', err)
    });
  }

  editCredito(credito: Credito) {
    this.creditoSelected.emit({ action: 'modifica', credito });
  }

  deleteCredito(id: number) {
    this.cancellaValore(id);
  }

  cancellaValore(id: number) {
    this.api.deleteCredito(id.toString()).subscribe({
      next: () => {
        console.log("Credito deleted:", id);
        this.dati = this.dati.filter(credito => credito.idCredito !== id);
      },
      error: (err) => console.error('Error deleting credit:', err)
    });
  }

  getContattoName(idContatto: number): string {
    const contatto = this.contatti.find(c => c.idContatto === idContatto);
    return contatto ? `${contatto.nome} ${contatto.cognome}` : 'Unknown';
  }
}