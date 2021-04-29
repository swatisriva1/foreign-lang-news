import { Component } from '@angular/core';
import { Order } from './order';
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

  // drinks = ['Coffee', 'Tea', 'Milk'];
  types = ['General', 'Account', 'Content'];

  confirm_msg = '';
  data_submitted = '';


  /* create an instance of an Question */
  // orderModel = new Order('', '', null, '', '', null);
  questionModel = new Question('', '', '', '', '');
  
  confirmQuestion(data: any): void {
     console.log(data);
     this.confirm_msg = 'Thank you, ' + data.fname + ' ' + data.lname;
     this.confirm_msg += '. You asked: ' + data.qText;
  }


  responsedata = new Order('','',null,'','',null);    // to store a response from the backend

  // passing in a form variable of type any, no return result
  onSubmit(form: any): void {
     console.log('You submitted value: ', form);
     this.data_submitted = form;

     // console.log(this.data_submitted, this.data_submitted.name.length);
     console.log('form submitted ', form);

     /*------*/
     // Prepare to send a request to the backend PHP
     // 1. Convert the form data to JSON format
     let params = JSON.stringify(form);

     // 2. Send an HTTP request to a backend

     this.http.post<Order>('http://localhost/cs4640/ng-php/ng-post.php', params)
     .subscribe((response_from_php) => {
        // Receive a response successfully, do something here

        // Suppose we just want to assign a response from a PHP backend
        // to a responsedata property of this controller,
        // so that we can use it (or bind it) to display on screen

        this.responsedata = response_from_php;

        // The subcribe above means that this observable takes response_from_php
        // being emitted and set it to this.responsedata

     }, (error_in_communication) => {
        // An error occurs, handle an error in some way.
        console.log('Error ', error_in_communication);
     })

  }
}

