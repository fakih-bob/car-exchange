import 'package:carexchange/Components/MyTextField.dart';
import 'package:carexchange/Controller/UpdateController.dart';
import 'package:carexchange/Controller/UpdateUser.dart';
import 'package:carexchange/Routes/AppRoute.dart';
import 'package:carexchange/models/User.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';

class Updateuser extends StatelessWidget {
  final Updateusercontroller updateusercontroller =
      Get.put(Updateusercontroller());
  final User user;
  Updateuser({Key? key, required this.user}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.grey,
      body: SingleChildScrollView(
        child: SafeArea(
          child: Center(
            child: Column(
              children: [
                const SizedBox(height: 25),
                Text(
                  "Edit your post",
                  style: TextStyle(fontWeight: FontWeight.bold, fontSize: 25),
                ),
                const SizedBox(height: 50),
                MyTextfield(
                  obscureText: false,
                  hintText: 'Name',
                  controller: updateusercontroller.name,
                ),
                const SizedBox(height: 18),
                MyTextfield(
                  obscureText: false,
                  hintText: 'Email',
                  controller: updateusercontroller.email,
                ),
                const SizedBox(height: 18),
                MyTextfield(
                  obscureText: false,
                  hintText: 'Color',
                  controller: updateusercontroller.phoneNumber,
                ),
                const SizedBox(height: 18),
                ElevatedButton(
                  onPressed: () {
                    updateusercontroller.updateuser();
                    Get.offNamed(AppRoute.user);
                  },
                  child: const Text('Update Post'),
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }
}
