public function alpha_dot_space($fullname){
    if (! preg_match('/^[a-zA-Z\s.]+$/', $fullname)) {
        $this->form_validation->set_message('alpha_dash_space', 'The %s field may only contain alpha characters, dots and White spaces');
        return FALSE;
    } else {
        return TRUE;
    }
}