import { Component } from '@angular/core';
import { Question } from './question';

import { HttpClient, HttpErrorResponse, HttpParams } from '@angular/common/http';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {

  // dependency injection
  constructor(private http: HttpClient) {  }

  title = 'Questions?';
  author = 'Swati Srivastava (ss3ck) and Megan Reddy (mr8vn)';

  show_directions = false;

  types = ['General', 'Account', 'Content'];

  confirm_msg = '';
  data_submitted = '';


  // create an instance of a Question
  questionModel = new Question('', '', '', '', '', '');

  toggleDirections() {
     this.show_directions = !this.show_directions;
  }
  
  confirmQuestion(data: any): void {
     console.log(data);
     this.confirm_msg = 'Thank you, ' + data.fname + ' ' + data.lname;
     this.confirm_msg += '. You asked: ' + data.qText;
  }


//   responsedata = new Question('', '', '', '', '', '');   // to store a response from the backend
  responsedata = '';

  // pass in a form variable of type any, no return result
  onSubmit(form: any): void {
     console.log('You submitted value: ', form);
     this.data_submitted = form;

     console.log('form submitted ', form);

     // Prepare to send a request to the backend PHP
     // 1. Convert the form data to JSON format
     let params = JSON.stringify(form);

     // 2. Send an HTTP request to the backend
     this.http.post<string>('http://localhost/cs4640/foreign-lang-news/questionsDB.php', params)
     .subscribe((response_from_php) => {

        // Assign response from PHP backend to a responsedata property 
        this.responsedata = "Thank you, " + form.fname + ". " + response_from_php + " Please click 'Exit' to close the form. ";

     }, (error_in_communication) => {
        // An error occurs, handle here
        console.log('Error ', error_in_communication);
     })

  }
}

