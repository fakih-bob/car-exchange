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
      backgroundColor: Color(0xFFF5F7FA),
      appBar: AppBar(
        title: const Text('Update User Profile'),
        leading: IconButton(
          icon: const Icon(Icons.arrow_back),
          onPressed: () {
            Get.offNamed(
                AppRoute.posts); // Navigates back to the previous screen
          },
        ),
        backgroundColor: const Color.fromARGB(255, 4, 59, 154),
      ),
      body: SingleChildScrollView(
        child: SafeArea(
          child: Center(
            child: Column(
              children: [
                const SizedBox(height: 25),
                Text(
                  "Edit your Profile",
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
                  hintText: 'PhoneNumber',
                  controller: updateusercontroller.phoneNumber,
                ),
                const SizedBox(height: 18),
                ElevatedButton(
                    onPressed: () {
                      updateusercontroller.updateuser();
                    },
                    child: const Text('Update User'),
                    style: ElevatedButton.styleFrom(
                      foregroundColor: Colors.white,
                      backgroundColor: const Color.fromARGB(255, 4, 59, 154),
                      padding:
                          EdgeInsets.symmetric(horizontal: 24, vertical: 12),
                      textStyle: TextStyle(fontSize: 18),
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(30),
                      ),
                    )),
              ],
            ),
          ),
        ),
      ),
    );
  }
}
