import 'package:carexchange/Controller/LoginController.dart';
import 'package:get/get.dart';

class Loginbinding extends Bindings {
  @override
  void dependencies() {
    Get.lazyPut(() => LoginController());
  }
}
