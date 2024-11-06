import { Injectable } from '@angular/core';
import { EntityDataSource } from '../../../components/entity-list/entity-data-source.service';
import { User } from '../../../models/entity/user.class';
import { UserService } from '../../../services/user.service';

@Injectable({
  providedIn: 'root',
})
export class UsersListDataSource extends EntityDataSource<User> {
  constructor(
    userService: UserService,
  ) {
    super(userService);
  }
}
