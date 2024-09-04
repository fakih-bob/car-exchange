import 'package:carexchange/Controller/RegistrationController.dart';
import 'package:get/get.dart';

class Registrationbinding extends Bindings {
  @override
  void dependencies() {
    Get.lazyPut(() => RegistrationController());
  }
}
